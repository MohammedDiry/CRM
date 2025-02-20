<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Project;
use App\Models\ProjectTeam;


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
    public function create(Request $request)
    {
        // استرجاع المشروع بناءً على project_id الذي تم تمريره في الرابط
        $project = Project::findOrFail($request->query('project_id'));

        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف جزءًا من فريق المشروع
        $isInProjectTeam = ProjectTeam::where('project_id', $project->id)
            ->where('employee_id', $currentEmployee->id)
            ->exists();

        // إذا لم يكن المستخدم Admin ولم يكن ضمن فريق المشروع، يتم منعه من الوصول
        if (!$isAdmin && !$isInProjectTeam) {
            return redirect()->route('projects.show', $project->id)->with('error', 'ليس لديك صلاحية للوصول إلى صفحة إنشاء المصروف.');
        }

        // إرسال المشروع إلى الواجهة
        return view('expenses.create', compact('project'));
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
        ]);

        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف جزءًا من فريق المشروع
        $isInProjectTeam = ProjectTeam::where('project_id', $request->project_id)
            ->where('employee_id', $currentEmployee->id)
            ->exists();

        // إذا لم يكن المستخدم Admin ولم يكن ضمن فريق المشروع، يتم منعه من إنشاء المصروف
        if (!$isAdmin && !$isInProjectTeam) {
            return redirect()->route('projects.show', $request->project_id)->with('error', 'ليس لديك صلاحية لإنشاء مصروف لهذا المشروع.');
        }

        // إنشاء المصروف الجديد مع إضافة حقل credited_by كموظف الحالي
        Expense::create(array_merge($request->all(), ['credited_by' => $currentEmployee->id]));

        // إعادة التوجيه إلى صفحة المصاريف مع رسالة نجاح
        return redirect()->route('projects.show', $request->project_id)->with('success', 'تم إضافة المصروف بنجاح');
    }


    // عرض نموذج لتعديل مصروف معين
    public function edit($id)
    {
        // جلب المصروف مع المشاريع المتاحة
        $expense = Expense::findOrFail($id);

        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف هو الذي أنشأ المصروف
        $isCreator = $expense->created_by === $currentEmployee->id;

        // إذا لم يكن المستخدم Admin ولم يكن هو الذي أنشأ المصروف، يتم منعه من الوصول
        if (!$isAdmin && !$isCreator) {
            return redirect()->route('expenses.index')->with('error', 'ليس لديك صلاحية للوصول إلى صفحة التعديل.');
        }

        // جلب المشاريع المتاحة
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
        ]);

        // جلب المصروف وتحديثه
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());

        // إعادة التوجيه إلى صفحة المصاريف مع رسالة نجاح
        return redirect()->route('projects.show', $request->project_id)->with('success', 'تم تحديث المصروف بنجاح');
    }

    // حذف مصروف
    public function destroy(Request $request, $id)
    {
        // جلب المصروف
        $expense = Expense::findOrFail($id);

        // حفظ ID المشروع قبل حذف المصروف
        $projectId = $expense->project_id;

        // حذف المصروف
        $expense->delete();

        // إعادة التوجيه إلى صفحة عرض المشروع مع تمرير project_id
        return redirect()->route('projects.show', ['project' => $projectId])
            ->with('success', 'تم حذف المصروف بنجاح');
    }
}
