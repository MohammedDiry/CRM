<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Employee;


class ReportController extends Controller
{

     // عرض جميع التقارير
     public function index()
     {
        $reports = Report::with('generatedBy')->get(); // تحميل العلاقة مع الموظف
        return view('reports.index', compact('reports'));
     }

     // عرض نموذج لإضافة تقرير جديد
     public function create()
     {
         // جلب جميع الموظفين لربطهم بالتقرير
         $employees = Employee::all();

         return view('reports.create', compact('employees'));
     }

     // حفظ تقرير جديد في قاعدة البيانات
     public function store(Request $request)
     {
         // التحقق من صحة البيانات المدخلة
         $request->validate([
             'report_type' => 'required|in:Financial,Project Summary,Performance', // التحقق من نوع التقرير
             'generated_by' => 'required|exists:employees,id', // التحقق من الموظف الذي أنشأ التقرير
             'data' => 'required|string', // التحقق من وجود بيانات التقرير
         ]);

         // إنشاء التقرير الجديد
         Report::create([
             'report_type' => $request->report_type,
             'generated_by' => $request->generated_by,
             'data' => $request->data, // تخزين البيانات كنص
         ]);

         // إعادة التوجيه إلى صفحة التقارير مع رسالة نجاح
         return redirect()->route('reports.index')->with('success', 'تم إضافة التقرير بنجاح');
     }

     // عرض نموذج لتعديل تقرير معين
     public function edit($id)
     {
         // جلب التقرير بناءً على المعرف
         $report = Report::findOrFail($id);
         $employees = Employee::all(); // جلب جميع الموظفين لربطهم بالتقرير

         return view('reports.edit', compact('report', 'employees'));
     }

     // تحديث بيانات التقرير
     public function update(Request $request, $id)
     {
         // التحقق من صحة البيانات المدخلة
         $request->validate([
             'report_type' => 'required|in:Financial,Project Summary,Performance',
             'generated_by' => 'required|exists:employees,id',
             'data' => 'required|string',
         ]);

         // جلب التقرير وتحديثه
         $report = Report::findOrFail($id);
         $report->update([
             'report_type' => $request->report_type,
             'generated_by' => $request->generated_by,
             'data' => $request->data, // تحديث البيانات
         ]);

         // إعادة التوجيه إلى صفحة التقارير مع رسالة نجاح
         return redirect()->route('reports.index')->with('success', 'تم تحديث التقرير بنجاح');
     }

     // حذف تقرير
     public function destroy($id)
     {
         // جلب التقرير وحذفه
         $report = Report::findOrFail($id);
         $report->delete();

         // إعادة التوجيه إلى صفحة التقارير مع رسالة نجاح
         return redirect()->route('reports.index')->with('success', 'تم حذف التقرير بنجاح');
     }
}
