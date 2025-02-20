<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\User;






class EmployeeController extends Controller
{

    // عرض جميع الموظفين
    public function index()
    {
        // جلب جميع الموظفين
        $employees = Employee::all();

        return view('employees.index', compact('employees'));
    }

    // عرض نموذج لإضافة موظف جديد
    public function create()
    {
        return view('employees.create');
    }

    // حفظ موظف جديد في قاعدة البيانات
    public function store(Request $request)
    {
        // جلب المستخدم الحالي
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // السماح بإنشاء موظف فقط لموظف دوره "Admin" أو مستخدم دوره "Admin"
        if (!($currentEmployee && $currentEmployee->role === 'Admin') && $currentUser->role !== 'Admin') {
            return redirect()->route('employees.index')->with('error', 'Unauthorized to create an employee.');
        }

        // التحقق من البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed', // كلمة المرور
            'role' => 'required|in:Admin,CSR,Accountant,Employee', // التحقق من دور الموظف
        ]);

        // **السماح بإنشاء موظف بدور "Admin" فقط إذا كان المستخدم الحالي دوره "Admin"**
        if ($request->role === 'Admin' && $currentUser->role !== 'Admin') {
            return redirect()->route('employees.index')->with('error', 'Only a user with Admin role can create an Admin employee.');
        }

        // إنشاء الموظف
        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,  // تعيين دور الموظف
            'password' => Hash::make($request->password),
        ]);

        // إنشاء المستخدم (User) وربطه بالموظف
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),  // نفس كلمة المرور
            'role' => 'Regular',  // تعيين دور المستخدم كـ "Regular" دائمًا
            'employee_id' => $employee->id, // ربط الموظف بالمستخدم
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }




    public function show($id)
    {
        // جلب الموظف بناءً على الـ ID
        $employee = Employee::with([
            'projects', // المشاريع التي عمل بها
            'projects.team', // الموظفين في المشاريع (الليدرات)
            'reports', // التقارير التي كتبها الموظف
            'leads', // العملاء التي تحت إشرافه
            'employeeRatings.project', // تقييمات الموظف على المشاريع
            'assignedClient' // العملاء الذين تحت إشرافه
        ])->findOrFail($id);

        // عرض الصفحة مع البيانات
        return view('employees.show', compact('employee'));
    }



    // عرض نموذج لتعديل موظف معين
    public function edit($id)
    {
        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // جلب الموظف المطلوب تعديله
        $employee = Employee::findOrFail($id);

        // التحقق مما إذا كان المستخدم لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || ($currentUser->role === 'Admin');

        // التحقق مما إذا كان الموظف الذي يريد التعديل هو نفسه الموظف الذي يتم تعديله
        $isOwner = $currentEmployee && $currentEmployee->id === $employee->id;

        // السماح فقط في حالة كونه Admin أو الموظف نفسه
        if (!$isAdmin && !$isOwner) {
            return redirect()->route('index')->with('error', 'Unauthorized to edit this employee.');
        }

        return view('employees.edit', compact('employee'));
    }


    // تحديث بيانات الموظف
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        // الحصول على المستخدم الحالي
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // السماح بالتعديل فقط لنفس الموظف أو لمن يملك صلاحيات Admin
        $canEdit = ($currentEmployee && $currentEmployee->id === $employee->id) ||
            ($currentEmployee && $currentEmployee->role === 'Admin') ||
            ($currentUser->role === 'Admin');

        if (!$canEdit) {
            return redirect()->route('employees.index')->with('error', 'Unauthorized to update this employee.');
        }

        // التحقق من البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string|max:255',
            'role' => 'required|in:Admin,CSR,Accountant,Employee',
            'password' => 'nullable|string|min:8|confirmed', // Ensure password is confirmed if provided
        ]);

        // تحديث بيانات الموظف
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        // إذا كان المستخدم Admin أو الموظف Admin يمكنه تعديل الدور
        if (($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin') {
            // إذا كان دور الموظف الحالي Admin، فلا يمكن تغييره إلا إذا كان المستخدم Admin
            if ($employee->role === 'Admin' && $currentUser->role !== 'Admin') {
                return redirect()->route('employees.index')->with('error', 'Only a user with Admin role can change an Admin role.');
            }
            $employee->role = $request->role;
        }

        $employee->save();

        // تحديث بيانات المستخدم المرتبط
        if ($user) {
            $user->email = $request->email; // مزامنة البريد الإلكتروني
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }



    // حذف موظف
    public function destroy($id)
    {
        // جلب الموظف مع المستخدم المرتبط به
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        // الحصول على المستخدم الحالي
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان الموظف الذي سيتم حذفه هو Admin
        if ($employee->role === 'Admin') {
            // لا يمكن حذف موظف Admin إلا بواسطة مستخدم دوره Admin
            if ($currentUser->role !== 'Admin') {
                return redirect()->route('employees.index')->with('error', 'Only a user with Admin role can delete an Admin employee.');
            }
        } else {
            // إذا لم يكن الموظف المحذوف Admin، يمكن حذفه بواسطة موظف دوره Admin أو مستخدم دوره Admin
            if (!($currentEmployee && $currentEmployee->role === 'Admin') && $currentUser->role !== 'Admin') {
                return redirect()->route('employees.index')->with('error', 'Unauthorized to delete this employee.');
            }
        }

        // حذف المستخدم المرتبط إذا كان موجودًا
        if ($user) {
            $user->delete();
        }

        // حذف الموظف
        $employee->delete();

        // إعادة التوجيه إلى صفحة الموظفين مع رسالة نجاح
        return redirect()->route('employees.index')->with('success', 'تم حذف الموظف والمستخدم المرتبط به بنجاح');
    }
}
