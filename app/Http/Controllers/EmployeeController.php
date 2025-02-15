<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;





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
          // التحقق من صحة البيانات المدخلة
          $request->validate([
              'name' => 'required|string|max:255',
              'email' => 'required|email|unique:employees,email',
              'phone' => 'required|string',
              'role' => 'required|in:Admin,Accountant,Employee', // التأكد من صلاحية الدور
              'password' => 'required|string|min:8|confirmed', // التحقق من صحة كلمة المرور
          ]);

          // إنشاء الموظف الجديد
          Employee::create([
              'name' => $request->name,
              'email' => $request->email,
              'phone' => $request->phone,
              'role' => $request->role,
              'password' => bcrypt($request->password), // تشفير كلمة المرور
          ]);

          // إعادة التوجيه إلى صفحة الموظفين مع رسالة نجاح
          return redirect()->route('employees.index')->with('success', 'تم إضافة الموظف بنجاح');
      }

      // عرض نموذج لتعديل موظف معين
      public function edit($id)
      {
          // جلب الموظف بناءً على المعرف
          $employee = Employee::findOrFail($id);

          return view('employees.edit', compact('employee'));
      }

      // تحديث بيانات الموظف
      public function update(Request $request, $id)
      {
          // التحقق من صحة البيانات المدخلة
          $request->validate([
              'name' => 'required|string|max:255',
              'email' => 'required|email|unique:employees,email,' . $id,
              'phone' => 'required|string',
              'role' => 'required|in:Admin,Accountant,Employee',
              'password' => 'nullable|string|min:8|confirmed', // كلمة المرور اختيارية في التحديث
          ]);

          // جلب الموظف وتحديثه
          $employee = Employee::findOrFail($id);
          $employee->update([
              'name' => $request->name,
              'email' => $request->email,
              'phone' => $request->phone,
              'role' => $request->role,
              'password' => $request->password ? bcrypt($request->password) : $employee->password, // تحديث كلمة المرور فقط إذا تم إدخالها
          ]);

          // إعادة التوجيه إلى صفحة الموظفين مع رسالة نجاح
          return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف بنجاح');
      }

      // حذف موظف
      public function destroy($id)
      {
          // جلب الموظف وحذفه
          $employee = Employee::findOrFail($id);
          $employee->delete();

          // إعادة التوجيه إلى صفحة الموظفين مع رسالة نجاح
          return redirect()->route('employees.index')->with('success', 'تم حذف الموظف بنجاح');
      }
}
