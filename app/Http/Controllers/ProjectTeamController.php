<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTeam;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;


class ProjectTeamController extends Controller
{


    // عرض فرق المشاريع
    public function index()
    {
        $teams = ProjectTeam::with('project', 'employee')->get();
        return view('project_teams.index', compact('teams'));
    }

    // عرض نموذج لإضافة فريق مشروع جديد
    public function create(Request $request)
    {
        // استخدم $request للحصول على projectId من الـ URL
        $projectId = $request->route('projectId');

        // العثور على المشروع باستخدام $projectId
        $project = Project::findOrFail($projectId);
        $employees = Employee::all();

        return view('project-teams.create', compact('project', 'employees'));
    }


    // حفظ فريق المشروع في قاعدة البيانات
    public function store(Request $request, $projectId)
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
            'team_lead_id' => 'nullable|exists:employees,id',
        ]);

        // التحقق مما إذا كان هناك فريق للمشروع مسبقًا
        if (ProjectTeam::where('project_id', $projectId)->exists()) {
            return redirect()->route('projects.show', $projectId)
                ->with('error', 'هذا المشروع لديه فريق بالفعل. يمكنك تعديله بدلاً من ذلك.');
        }

        // التأكد من إضافة قائد الفريق ضمن الأعضاء إن لم يكن موجودًا
        if (!in_array($validated['team_lead_id'], $validated['employee_ids'])) {
            $validated['employee_ids'][] = $validated['team_lead_id'];
        }

        // إضافة الفريق الجديد
        foreach ($validated['employee_ids'] as $employeeId) {
            ProjectTeam::create([
                'project_id' => $projectId,
                'employee_id' => $employeeId,
                'assigned_date' => now(),
                'team_lead_id' => $validated['team_lead_id'], // سيتم تعيين نفس القائد لجميع السجلات
            ]);
        }

        return redirect()->route('projects.show', $projectId)->with('success', 'تمت إضافة الفريق بنجاح.');
    }





    // عرض تفاصيل فريق مشروع معين
    public function show($id)
    {
        $team = ProjectTeam::with('project', 'employee')->findOrFail($id);
        return view('project-teams.show', compact('team'));
    }

    // حذف موظف من فريق المشروع
    public function destroy($id)
    {
        $team = ProjectTeam::findOrFail($id);
        $team->delete();

        return redirect()->route('project-teams.index')->with('success', 'تم حذف الموظف من الفريق بنجاح');
    }

    public function edit($projectId)
    {
        // جلب الموظفين المرتبطين بالمشروع


        // جلب جميع الموظفين لإضافتهم للفريق
        $project = Project::findOrFail($projectId);
        $team = $project->team()->first();
        $employees = Employee::all();
        $teamMembers = $project->team()->pluck('employee_id')->toArray();

        return view('project-teams.edit', compact('project', 'team', 'employees', 'teamMembers'));
    }


    public function update(Request $request, Project $project)
    {
        // تحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
            'team_lead_id' => 'nullable|exists:employees,id',
        ]);

        // التأكد من أن قائد الفريق مضاف إلى قائمة الأعضاء
        if ($validated['team_lead_id'] && !in_array($validated['team_lead_id'], $validated['employee_ids'])) {
            $validated['employee_ids'][] = $validated['team_lead_id'];
        }

        // تحديث أعضاء الفريق (sync يزيل العلاقات السابقة ويضيف الجديد)
        $project->team()->sync($validated['employee_ids']);

        // تحديث قائد الفريق في جدول project_team
        DB::table('project_team')
            ->where('project_id', $project->id)
            ->update(['team_lead_id' => $validated['team_lead_id']]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'تم تحديث فريق المشروع بنجاح!');
    }
}
