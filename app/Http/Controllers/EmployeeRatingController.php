<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeRating;
use App\Models\Employee;
use App\Models\Project;

class EmployeeRatingController extends Controller
{
      // المُنشئ لإضافة التوثيق والتفويض (اختياري)
      public function __construct()
      {
          $this->middleware('auth');
      }

      // عرض تقييمات الموظفين
      public function index()
      {
          $ratings = EmployeeRating::with('employee', 'project')->get();
          return view('employee_ratings.index', compact('ratings'));
      }

      // عرض نموذج لإضافة تقييم للموظف
      public function create()
      {
          $employees = Employee::all();
          $projects = Project::all();
          return view('employee_ratings.create', compact('employees', 'projects'));
      }

      // حفظ تقييم الموظف في قاعدة البيانات
      public function store(Request $request)
      {
          $request->validate([
              'employee_id' => 'required|exists:employees,id',
              'project_id' => 'required|exists:projects,id',
              'rating' => 'required|integer|min:1|max:5',
              'review' => 'nullable|string',
          ]);

          EmployeeRating::create([
              'employee_id' => $request->employee_id,
              'project_id' => $request->project_id,
              'rating' => $request->rating,
              'review' => $request->review,
          ]);

          return redirect()->route('employee_ratings.index')->with('success', 'تم إضافة التقييم بنجاح');
      }

      // عرض تقييم موظف معين
      public function show($id)
      {
          $rating = EmployeeRating::with('employee', 'project')->findOrFail($id);
          return view('employee_ratings.show', compact('rating'));
      }

      // تحديث تقييم موظف معين
      public function edit($id)
      {
          $rating = EmployeeRating::findOrFail($id);
          $employees = Employee::all();
          $projects = Project::all();
          return view('employee_ratings.edit', compact('rating', 'employees', 'projects'));
      }

      // حفظ التحديثات على التقييم
      public function update(Request $request, $id)
      {
          $request->validate([
              'employee_id' => 'required|exists:employees,id',
              'project_id' => 'required|exists:projects,id',
              'rating' => 'required|integer|min:1|max:5',
              'review' => 'nullable|string',
          ]);

          $rating = EmployeeRating::findOrFail($id);
          $rating->update([
              'employee_id' => $request->employee_id,
              'project_id' => $request->project_id,
              'rating' => $request->rating,
              'review' => $request->review,
          ]);

          return redirect()->route('employee_ratings.index')->with('success', 'تم تحديث التقييم بنجاح');
      }

      // حذف تقييم
      public function destroy($id)
      {
          $rating = EmployeeRating::findOrFail($id);
          $rating->delete();

          return redirect()->route('employee_ratings.index')->with('success', 'تم حذف التقييم بنجاح');
      }
}
