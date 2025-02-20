<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectTeam;


class ReportController extends Controller
{

    // عرض جميع التقارير
    public function index()
    {
        $reports = Report::with('generatedBy', 'project')->get(); // تحميل العلاقة مع الموظف
        return view('reports.index', compact('reports'));
    }

    // عرض نموذج لإضافة تقرير جديد
    public function create(Request $request)
    {
        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // جلب المشاريع
        $projects = Project::all();
        $selectedProjectId = $request->query('project_id'); // استقبال الـ project_id إذا كان موجودًا

        // التحقق مما إذا كان هناك مشروع محدد
        if ($selectedProjectId) {
            // التحقق مما إذا كان الموظف لديه صلاحيات Admin
            $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

            // التحقق مما إذا كان الموظف جزءًا من فريق المشروع
            $isInProjectTeam = ProjectTeam::where('project_id', $selectedProjectId)
                ->where('employee_id', $currentEmployee->id)
                ->exists();

            // إذا لم يكن الموظف أدمن أو عضو في فريق المشروع، يتم منعه من الوصول
            if (!$isAdmin && !$isInProjectTeam) {
                return redirect()->route('reports.index')->with('error', 'Unauthorized to create a report for this project.');
            }
        }

        // إرجاع عرض إنشاء التقرير مع البيانات المطلوبة
        return view('reports.create', compact('projects', 'selectedProjectId'));
    }



    // حفظ تقرير جديد في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'report_type' => 'required|in:Financial,Project Summary,Performance', // التحقق من نوع التقرير
            'data' => 'required|string', // التحقق من وجود بيانات التقرير
            'project_id' => 'nullable|exists:projects,id', // التحقق من وجود المشروع إذا كان مرفقًا
        ]);

        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف جزءًا من فريق المشروع
        $isInProjectTeam = false;
        if ($request->project_id) {
            $isInProjectTeam = ProjectTeam::where('project_id', $request->project_id)
                ->where('employee_id', $currentEmployee->id)
                ->exists();
        }

        // إذا كان التقرير مرتبطًا بمشروع، يتم تطبيق شرط التحقق
        if ($request->project_id && !$isAdmin && !$isInProjectTeam) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized to create a report for this project.');
        }

        // إنشاء التقرير الجديد
        Report::create([
            'report_type' => $request->report_type,
            'generated_by' => $currentEmployee->id, // إضافة معرف الموظف الذي أنشأ التقرير
            'data' => $request->data, // تخزين البيانات كنص
            'project_id' => $request->project_id, // تخزين معرف المشروع إذا تم توفيره
        ]);

        // إعادة التوجيه إلى الصفحة الخلفية مع رسالة نجاح
        return redirect()->route('reports.index')->with('success', 'تم إضافة التقرير بنجاح');
    }






    public function show($id)
    {
        // Retrieve the report by ID along with its related project and employee data
        $report = Report::with(['project', 'generatedBy'])->findOrFail($id);

        // Pass data to the view
        return view('reports.show', compact('report'));
    }



    // عرض نموذج لتعديل تقرير معين
    public function edit($id)
    {
        // جلب التقرير من قاعدة البيانات باستخدام معرفه
        $report = Report::findOrFail($id);

        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم هو الذي أنشأ التقرير أو لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';
        $isReportOwner = $report->generated_by === $currentEmployee->id;

        // إذا لم يكن المستخدم هو مالك التقرير أو لا يمتلك صلاحيات Admin، إرجاع رسالة خطأ
        if (!$isReportOwner && !$isAdmin) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized to edit this report.');
        }

        // جلب المشاريع (إذا كنت بحاجة إلى عرضها في القائمة المنسدلة)
        $projects = Project::all();

        // إرجاع عرض تعديل التقرير مع البيانات المطلوبة
        return view('reports.edit', compact('report', 'projects'));
    }



    // تحديث بيانات التقرير
    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'report_type' => 'required|in:Financial,Project Summary,Performance', // التحقق من نوع التقرير
            'data' => 'required|string', // التحقق من وجود بيانات التقرير
            'project_id' => 'nullable|exists:projects,id', // التحقق من وجود المشروع إذا كان مرفقًا
        ]);

        // جلب التقرير من قاعدة البيانات باستخدام معرفه
        $report = Report::findOrFail($id);

        // جلب المستخدم الحالي
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق من صلاحيات التعديل
        $isCreator = $report->generated_by === $currentEmployee->id; // التأكد من أن الموظف هو من أنشأ التقرير
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        if (!$isCreator && !$isAdmin) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized to update this report.');
        }

        // تحديث التقرير بالبيانات الجديدة
        $report->update([
            'report_type' => $request->report_type,
            'data' => $request->data, // تخزين البيانات كنص
            'project_id' => $request->project_id, // تخزين معرف المشروع إذا تم توفيره
        ]);

        // إعادة التوجيه إلى صفحة عرض التقارير مع رسالة نجاح
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
