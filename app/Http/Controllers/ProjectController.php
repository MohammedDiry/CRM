<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use App\Models\Employee;

class ProjectController extends Controller
{

      // عرض قائمة بجميع المشاريع
      public function index()
      {
          // جلب جميع المشاريع مع العميل المرتبط بكل مشروع
          $projects = Project::with('client')->get();

          return view('projects.index', compact('projects'));
      }

      // عرض نموذج لإضافة مشروع جديد
      public function create()
      {
          // جلب جميع العملاء والموظفين لاختيار العميل وتعيين الموظفين
          $clients = Client::all();
          $employees = Employee::all();

          return view('projects.create', compact('clients', 'employees'));
      }

      // حفظ مشروع جديد في قاعدة البيانات
      public function store(Request $request)
      {
          // التحقق من صحة البيانات المدخلة
          $request->validate([
              'name' => 'required|string|max:255',
              'client_id' => 'required|exists:clients,id', // التأكد من وجود العميل
              'start_date' => 'required|date',
              'end_date' => 'nullable|date',
              'budget' => 'required|numeric',
              'status' => 'required|in:Ongoing,Completed,On Hold',
          ]);

          // إنشاء المشروع الجديد
          Project::create($request->all());

          // إعادة التوجيه إلى صفحة المشاريع مع رسالة نجاح
          return redirect()->route('projects.index')->with('success', 'تم إنشاء المشروع بنجاح');
      }

      // عرض نموذج لتعديل مشروع معين
      public function edit($id)
      {
          // جلب المشروع مع العملاء والموظفين
          $project = Project::findOrFail($id);
          $clients = Client::all();
          $employees = Employee::all();

          return view('projects.edit', compact('project', 'clients', 'employees'));
      }

      // تحديث مشروع معين في قاعدة البيانات
      public function update(Request $request, $id)
      {
          // التحقق من صحة البيانات المدخلة
          $request->validate([
              'name' => 'required|string|max:255',
              'client_id' => 'required|exists:clients,id',
              'start_date' => 'required|date',
              'end_date' => 'nullable|date',
              'budget' => 'required|numeric',
              'status' => 'required|in:Ongoing,Completed,On Hold',
          ]);

          // جلب المشروع وتحديثه
          $project = Project::findOrFail($id);
          $project->update($request->all());

          // إعادة التوجيه إلى صفحة المشاريع مع رسالة نجاح
          return redirect()->route('projects.index')->with('success', 'تم تحديث المشروع بنجاح');
      }

      // حذف مشروع معين من قاعدة البيانات
      public function destroy($id)
      {
          // جلب المشروع وحذفه
          $project = Project::findOrFail($id);
          $project->delete();

          // إعادة التوجيه إلى صفحة المشاريع مع رسالة نجاح
          return redirect()->route('projects.index')->with('success', 'تم حذف المشروع بنجاح');
      }
}
