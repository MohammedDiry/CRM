<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeRating;
use App\Models\Employee;
use App\Models\Project;

class EmployeeRatingController extends Controller
{


    // عرض تقييمات الموظفين
    public function index()
    {
        $ratings = EmployeeRating::with('employee', 'project')->get();
        return view('employee_ratings.index', compact('ratings'));
    }

    public function create($project, $employee)
    {
        $project = Project::findOrFail($project);  // جلب المشروع باستخدام المعرف
        $employee = Employee::findOrFail($employee); // جلب الموظف باستخدام المعرف

        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف قائد الفريق
        $isTeamLeader = $project->teamLeader->id === $currentEmployee->id;

        // إذا كان قائد الفريق يحاول تقييم نفسه، منع الوصول
        if ($isTeamLeader && $employee->id === $currentEmployee->id) {
            return redirect()->route('projects.show', $project->id)->with('error', 'لا يمكنك تقييم نفسك كقائد فريق.');
        }

        // السماح بالدخول إلى صفحة إنشاء التقييم فقط إذا كان Admin أو Team Leader
        if (!$isAdmin && !$isTeamLeader) {
            return redirect()->route('projects.show', $project->id)->with('error', 'ليس لديك صلاحية لتقييم هذا الموظف.');
        }

        // السماح بالدخول إلى صفحة إنشاء التقييم
        return view('employee-ratings.create', compact('project', 'employee'));
    }




    public function store(Request $request)
    {
        // جلب المستخدم الحالي
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // جلب المشروع ومعرفة قائد الفريق
        $project = Project::findOrFail($request->input('project'));
        $teamLeaderId = $project->teamLeader->id;

        // التحقق مما إذا كان قائد الفريق يحاول تقييم نفسه
        if ($currentEmployee->id === $teamLeaderId && $currentEmployee->id === $request->input('employee_id')) {
            return redirect()->route('projects.show', $project->id)->with('error', 'لا يمكنك تقييم نفسك كقائد فريق.');
        }

        // السماح فقط لـ Admin أو قائد الفريق بإضافة التقييم
        if (!$isAdmin && $currentEmployee->id !== $teamLeaderId) {
            return redirect()->route('projects.show', $project->id)->with('error', 'ليس لديك صلاحية لإضافة تقييم لهذا الموظف.');
        }

        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
            'project' => 'required|exists:projects,id',
        ]);

        // إنشاء التقييم
        $rating = new EmployeeRating();
        $rating->project_id = $request->input('project');
        $rating->employee_id = $request->input('employee_id');
        $rating->rating = $request->input('rating');
        $rating->review = $request->input('review');
        $rating->save();

        // إعادة التوجيه مع رسالة النجاح
        return redirect()->route('projects.show', $rating->project_id)->with('success', 'Rating added successfully!');
    }





    // تحديث تقييم موظف معين
    public function edit($id)
    {
        $rating = EmployeeRating::findOrFail($id);
        $project = $rating->project;  // جلب المشروع المرتبط بالتقييم
        $employee = $rating->employee;  // جلب الموظف المرتبط بالتقييم

        // جلب المستخدم الحالي
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // جلب قائد الفريق
        $teamLeaderId = $project->teamLeader->id;

        // التحقق مما إذا كان قائد الفريق يحاول تعديل تقييم نفسه
        if ($currentEmployee->id === $teamLeaderId && $currentEmployee->id === $employee->id) {
            return redirect()->route('projects.show', $project->id)->with('error', 'لا يمكنك تعديل تقييم نفسك كقائد فريق.');
        }

        // السماح فقط لـ Admin أو قائد الفريق بالدخول إلى صفحة تعديل التقييم
        if (!$isAdmin && $currentEmployee->id !== $teamLeaderId) {
            return redirect()->route('projects.show', $project->id)->with('error', 'ليس لديك صلاحية للدخول إلى صفحة تعديل هذا التقييم.');
        }

        return view('employee-ratings.edit', compact('rating', 'project', 'employee'));
    }

    // حفظ التحديثات على التقييم
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
            'project' => 'required|exists:projects,id',
        ]);

        $rating = EmployeeRating::findOrFail($id);

        // جلب المستخدم الحالي
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // جلب قائد الفريق
        $teamLeaderId = $rating->project->teamLeader->id;

        // التحقق مما إذا كان قائد الفريق يحاول تحديث تقييم نفسه
        if ($currentEmployee->id === $teamLeaderId && $currentEmployee->id === $rating->employee_id) {
            return redirect()->route('projects.show', $rating->project_id)->with('error', 'لا يمكنك تحديث تقييم نفسك كقائد فريق.');
        }

        // السماح فقط لـ Admin أو قائد الفريق بالدخول إلى عملية التحديث
        if (!$isAdmin && $currentEmployee->id !== $teamLeaderId) {
            return redirect()->route('projects.show', $rating->project_id)->with('error', 'ليس لديك صلاحية لتحديث هذا التقييم.');
        }

        // تحديث بيانات التقييم
        $rating->rating = $request->input('rating');
        $rating->review = $request->input('review');
        $rating->save();

        return redirect()->route('projects.show', $rating->project_id)->with('success', 'Rating updated successfully!');
    }


    // حذف تقييم
    public function destroy($id)
    {
        $rating = EmployeeRating::findOrFail($id);
        $rating->delete();

        return redirect()->route('employee_ratings.index')->with('success', 'تم حذف التقييم بنجاح');
    }
}
