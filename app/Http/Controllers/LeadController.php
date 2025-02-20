<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class LeadController extends Controller
{
    // عرض جميع العملاء المحتملين
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }

    // عرض نموذج إضافة عميل محتمل جديد
    public function create()
    {
        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // إذا كان الموظف أو المستخدم Admin، جلب موظفي CSR فقط
        if ($isAdmin) {
            $employees = Employee::where('role', 'CSR')->get();
        } else {
            // إذا كان من باقي الموظفين، جلب الموظف نفسه فقط
            $employees = [$currentEmployee];
        }

        return view('leads.create', compact('employees'));
    }


    public function show($id)
    {
        // الحصول على العميل المحتمل بناءً على الـ id
        // تحقق من الملاحظات المرتبطة بالـ lead
        $lead = Lead::find($id);
        $notes = $lead->notes()->get();  // تأكد أن هذه القيمة تحتوي على ملاحظات أو كائن

        return view('leads.show', compact('lead', 'notes'));
    }


    // تخزين عميل محتمل جديد في قاعدة البيانات
    public function store(Request $request)
    {
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق من إدخال الموظف المسؤول
        if (!$isAdmin) {
            // إذا لم يكن Admin، يجب أن يكون الموظف المسؤول هو الموظف نفسه فقط
            if ($request->assigned_to != $currentEmployee->id) {
                return redirect()->back()->with('error', 'يمكنك تعيين نفسك فقط كموظف مسؤول.')->withInput();
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'required|string|max:15',
            'assigned_to' => 'required|exists:employees,id', // تحقق من وجود الموظف في قاعدة البيانات
        ]);

        Lead::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'New', // الافتراضي
            'source' => $request->source,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }


    // عرض نموذج تعديل بيانات العميل المحتمل
    public function edit(Lead $lead)
    {
        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف مرتبطًا بالعميل المحتمل
        $isAssignedToLead = $lead->assigned_to === $currentEmployee->id;

        // إذا لم يكن المستخدم Admin ولم يكن الموظف مرتبطًا بالعميل المحتمل، يتم منعه من الانتقال إلى صفحة التعديل
        if (!$isAdmin && !$isAssignedToLead) {
            return redirect()->route('leads.index')->with('error', 'ليس لديك صلاحية للدخول إلى صفحة تعديل العميل المحتمل.');
        }

        // استعراض الموظفين المعينين للمتابعة
        if ($isAdmin) {
            // إذا كان المستخدم Admin، جلب جميع الموظفين الذين لديهم دور CSR
            $employees = Employee::where('role', 'CSR')->get();
        } else {
            // إذا لم يكن المستخدم Admin، جلب الموظف نفسه فقط
            $employees = Employee::where('id', $currentEmployee->id)->get();
        }

        return view('leads.edit', compact('lead', 'employees'));
    }



    // تحديث بيانات العميل المحتمل في قاعدة البيانات


    public function update(Request $request, Lead $lead)
    {
        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف مرتبطًا بالعميل المحتمل
        $isAssignedToLead = $lead->assigned_to === $currentEmployee->id;

        // إذا لم يكن المستخدم Admin ولم يكن الموظف مرتبطًا بالعميل المحتمل، يتم منعه من التحديث
        if (!$isAdmin && !$isAssignedToLead) {
            return redirect()->route('leads.index')->with('error', 'ليس لديك صلاحية لتحديث بيانات العميل المحتمل.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email,' . $lead->id,
            'phone' => 'required|string|max:15',
            'assigned_to' => 'required|exists:employees,id',
        ]);

        // تحقق مما إذا كان الموظف المسؤول يحاول تعديل حقل المسؤول
        if ($currentEmployee->id === $lead->assigned_to && !$isAdmin) {
            // لا يسمح للموظف المسؤول بتعديل حقل المسؤول
            $request->validate([
                'assigned_to' => 'in:' . $currentEmployee->id, // السماح فقط لنفسه
            ]);
        }

        // تحقق مما إذا كان العميل قد تم تحويله إلى "Won" ولم يكن في هذه الحالة سابقًا
        $wasConverted = $lead->status !== 'Won' && $request->status === 'Won';

        // تحديث بيانات العميل المحتمل
        $lead->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'source' => $request->source,
            // تحديث حقل المسؤول فقط إذا كان المستخدم Admin
            'assigned_to' => $isAdmin ? $request->assigned_to : $lead->assigned_to,
        ]);

        // إذا تم تحويل العميل المحتمل إلى "Won"، نقوم بإنشاء سجل جديد في `clients`
        if ($wasConverted) {
            Client::create([
                'name' => $lead->name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'company_name' => $request->company_name ?? null,
                'address' => $request->address ?? null,
                'added_by' => Auth::user()->employee_id, // الموظف الذي قام بالتحويل
                'assigned_to' => $isAdmin ? $request->assigned_to : $lead->assigned_to, // الموظف المسؤول هو نفس الموظف المتصل
            ]);
        }

        return redirect()->route('leads.index')->with('success', 'تم تحديث بيانات العميل المحتمل بنجاح!');
    }




    // حذف العميل المحتمل من قاعدة البيانات
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully!');
    }
}
