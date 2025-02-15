<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;

class UserController extends Controller
{
     // المُنشئ لإضافة التوثيق والتفويض (اختياري)
     public function __construct()
     {
         $this->middleware('auth');
     }

     // عرض جميع المستخدمين
     public function index()
     {
         // جلب جميع المستخدمين
         $users = User::all();

         return view('users.index', compact('users'));
     }

     // عرض نموذج لإضافة مستخدم جديد
     public function create()
     {
         // جلب جميع الموظفين لربطهم بالمستخدم
         $employees = Employee::all();

         return view('users.create', compact('employees'));
     }

     // حفظ مستخدم جديد في قاعدة البيانات
     public function store(Request $request)
     {
         // التحقق من صحة البيانات المدخلة
         $request->validate([
             'username' => 'required|string|max:255|unique:users,username',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|string|min:8|confirmed', // التحقق من صحة كلمة المرور
             'employee_id' => 'required|exists:employees,id', // التأكد من أن الموظف موجود
             'role' => 'required|in:Admin,Regular', // التحقق من صلاحية الدور
         ]);

         // إنشاء المستخدم الجديد
         User::create([
             'username' => $request->username,
             'email' => $request->email,
             'password' => bcrypt($request->password), // تشفير كلمة المرور
             'employee_id' => $request->employee_id,
             'role' => $request->role,
         ]);

         // إعادة التوجيه إلى صفحة المستخدمين مع رسالة نجاح
         return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
     }

     // عرض نموذج لتعديل مستخدم معين
     public function edit($id)
     {
         // جلب المستخدم بناءً على المعرف
         $user = User::findOrFail($id);
         $employees = Employee::all(); // جلب جميع الموظفين لاختيار الموظف المرتبط بالمستخدم

         return view('users.edit', compact('user', 'employees'));
     }

     // تحديث بيانات المستخدم
     public function update(Request $request, $id)
     {
         // التحقق من صحة البيانات المدخلة
         $request->validate([
             'username' => 'required|string|max:255|unique:users,username,' . $id,
             'email' => 'required|email|unique:users,email,' . $id,
             'password' => 'nullable|string|min:8|confirmed', // كلمة المرور اختيارية في التحديث
             'employee_id' => 'required|exists:employees,id',
             'role' => 'required|in:Admin,Regular',
         ]);

         // جلب المستخدم وتحديثه
         $user = User::findOrFail($id);
         $user->update([
             'username' => $request->username,
             'email' => $request->email,
             'password' => $request->password ? bcrypt($request->password) : $user->password, // تحديث كلمة المرور فقط إذا تم إدخالها
             'employee_id' => $request->employee_id,
             'role' => $request->role,
         ]);

         // إعادة التوجيه إلى صفحة المستخدمين مع رسالة نجاح
         return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
     }

     // حذف مستخدم
     public function destroy($id)
     {
         // جلب المستخدم وحذفه
         $user = User::findOrFail($id);
         $user->delete();

         // إعادة التوجيه إلى صفحة المستخدمين مع رسالة نجاح
         return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
     }
}
