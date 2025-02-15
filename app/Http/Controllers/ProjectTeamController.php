<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTeam;
use App\Models\Project;
use App\Models\Employee;


class ProjectTeamController extends Controller
{
      // المُنشئ لإضافة التوثيق والتفويض (اختياري)
      public function __construct()
      {
          $this->middleware('auth');
      }

      // عرض فرق المشاريع
      public function index()
      {
          $teams = ProjectTeam::with('project', 'employee')->get();
          return view('project_teams.index', compact('teams'));
      }

      // عرض نموذج لإضافة فريق مشروع جديد
      public function create()
      {
          $employees = Employee::all();
          $projects = Project::all();
          return view('project_teams.create', compact('employees', 'projects'));
      }

      // حفظ فريق المشروع في قاعدة البيانات
      public function store(Request $request)
      {
          $request->validate([
              'project_id' => 'required|exists:projects,id',
              'employee_id' => 'required|exists:employees,id',
              'team_lead_id' => 'nullable|exists:employees,id',
          ]);

          ProjectTeam::create([
              'project_id' => $request->project_id,
              'employee_id' => $request->employee_id,
              'team_lead_id' => $request->team_lead_id,
              'assigned_date' => now(),
          ]);

          return redirect()->route('project_teams.index')->with('success', 'تم إضافة الموظف إلى الفريق بنجاح');
      }

      // عرض تفاصيل فريق مشروع معين
      public function show($id)
      {
          $team = ProjectTeam::with('project', 'employee')->findOrFail($id);
          return view('project_teams.show', compact('team'));
      }

      // حذف موظف من فريق المشروع
      public function destroy($id)
      {
          $team = ProjectTeam::findOrFail($id);
          $team->delete();

          return redirect()->route('project_teams.index')->with('success', 'تم حذف الموظف من الفريق بنجاح');
      }
}
