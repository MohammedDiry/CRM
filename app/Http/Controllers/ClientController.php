<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // عرض جميع العملاء
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    // عرض نموذج إضافة عميل جديد
    public function create()
    {
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // تحقق مما إذا كان المستخدم Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        if ($isAdmin) {
            // إذا كان المستخدم Admin، جلب جميع الموظفين الذين لديهم دور CSR
            $employees = Employee::where('role', 'CSR')->get();
        } else {
            // إذا لم يكن المستخدم Admin، جلب الموظف نفسه فقط
            $employees = Employee::where('id', $currentEmployee->id)->get();
        }

        // إرسال الموظفين إلى واجهة إنشاء العميل
        return view('clients.create', compact('employees'));
    }


    // تخزين عميل جديد في قاعدة البيانات
    public function store(Request $request)
    {
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:15',
            'assigned_to' => 'required|exists:employees,id', // تحقق من وجود الموظف
        ]);

        // تحقق مما إذا كان المستخدم Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // إذا لم يكن المستخدم Admin، تأكد من أن الموظف المعين هو نفسه الموظف الحالي
        if (!$isAdmin && $request->assigned_to != $currentEmployee->id) {
            return redirect()->back()->with('error', 'يمكنك فقط تعيين نفسك كموظف مسؤول.');
        }

        // إنشاء العميل الجديد
        Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'added_by' => Auth::user()->employee_id,
            'assigned_to' => $request->assigned_to, // إضافة الموظف المسؤول عن العميل
        ]);

        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }



    // في ClientController
    public function show($id)
    {
        // الحصول على العميل بناءً على الـ id
        $client = Client::findOrFail($id);
        return view('clients.show', compact('client'));
    }


    // عرض نموذج تعديل بيانات العميل
    public function edit(Client $client)
    {
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // تحقق مما إذا كان المستخدم Admin أو الموظف المسؤول عن العميل
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';
        $isAssignedEmployee = $client->assigned_to === $currentEmployee->id;

        // إذا لم يكن المستخدم Admin أو الموظف المسؤول، قم بإرجاع خطأ أو إعادة توجيه
        if (!$isAdmin && !$isAssignedEmployee) {
            return redirect()->route('clients.index')->with('error', 'ليس لديك صلاحية للوصول إلى صفحة تعديل العميل.');
        }

        // استرجاع الموظفين الذين دورهم CSR
        $employees = Employee::where('role', 'CSR')->get();

        // إذا كان الموظف المسؤول هو المستخدم الحالي، أرسل له نفسه فقط
        if ($isAssignedEmployee) {
            $employees = $employees->where('id', $currentEmployee->id);
        }

        return view('clients.edit', compact('client', 'employees'));
    }


    // تحديث بيانات العميل في قاعدة البيانات
    public function update(Request $request, Client $client)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'required|string|max:15',
        ]);

        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // تحقق مما إذا كان المستخدم Admin أو الموظف المسؤول عن العميل
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';
        $isAssignedEmployee = $client->assigned_to === $currentEmployee->id;

        // إذا لم يكن المستخدم Admin أو الموظف المسؤول، قم بإرجاع خطأ أو إعادة توجيه
        if (!$isAdmin && !$isAssignedEmployee) {
            return redirect()->route('clients.index')->with('error', 'ليس لديك صلاحية لتحديث بيانات العميل.');
        }

        // تحديث بيانات العميل
        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'address' => $request->address,
        ]);

        // إذا كان المستخدم ليس Admin، تأكد من عدم تغيير الموظف المسؤول
        if (!$isAdmin) {
            // تحقق مما إذا كان هناك تغيير في الموظف المسؤول
            if ($request->has('assigned_to') && $request->assigned_to != $client->assigned_to) {
                return redirect()->route('clients.index')->with('error', 'لا يمكنك تغيير الموظف المسؤول.');
            }
        }

        return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
    }


    // حذف العميل من قاعدة البيانات
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }
}
