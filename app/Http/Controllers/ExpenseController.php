<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Project;


class ExpenseController extends Controller
{

      // عرض جميع المصاريف
      public function index()
      {
          // جلب جميع المصاريف مع المشاريع المرتبطة بها
          $expenses = Expense::with('project')->get();

          return view('expenses.index', compact('expenses'));
      }

      // عرض نموذج لإضافة مصروف جديد
      public function create()
      {
          // جلب جميع المشاريع المتاحة لإمكانية تعيين مشروع للمصروف
          $projects = Project::all();

          return view('expenses.create', compact('projects'));
      }

      // حفظ مصروف جديد في قاعدة البيانات
      public function store(Request $request)
      {
          // التحقق من صحة البيانات المدخلة
          $request->validate([
              'project_id' => 'required|exists:projects,id', // التأكد من وجود المشروع
              'category' => 'required|in:Advertising,Software,Salaries,Miscellaneous',
              'amount' => 'required|numeric',
              'description' => 'nullable|string',
              'date' => 'required|date',
          ]);

          // إنشاء المصروف الجديد
          Expense::create($request->all());

          // إعادة التوجيه إلى صفحة المصاريف مع رسالة نجاح
          return redirect()->route('expenses.index')->with('success', 'تم إضافة المصروف بنجاح');
      }

      // عرض نموذج لتعديل مصروف معين
      public function edit($id)
      {
          // جلب المصروف مع المشاريع المتاحة
          $expense = Expense::findOrFail($id);
          $projects = Project::all();

          return view('expenses.edit', compact('expense', 'projects'));
      }

      // تحديث بيانات المصروف
      public function update(Request $request, $id)
      {
          // التحقق من صحة البيانات المدخلة
          $request->validate([
              'project_id' => 'required|exists:projects,id',
              'category' => 'required|in:Advertising,Software,Salaries,Miscellaneous',
              'amount' => 'required|numeric',
              'description' => 'nullable|string',
              'date' => 'required|date',
          ]);

          // جلب المصروف وتحديثه
          $expense = Expense::findOrFail($id);
          $expense->update($request->all());

          // إعادة التوجيه إلى صفحة المصاريف مع رسالة نجاح
          return redirect()->route('expenses.index')->with('success', 'تم تحديث المصروف بنجاح');
      }

      // حذف مصروف
      public function destroy($id)
      {
          // جلب المصروف وحذفه
          $expense = Expense::findOrFail($id);
          $expense->delete();

          // إعادة التوجيه إلى صفحة المصاريف مع رسالة نجاح
          return redirect()->route('expenses.index')->with('success', 'تم حذف المصروف بنجاح');
      }
}
