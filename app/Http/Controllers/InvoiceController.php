<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\ProjectTeam;

class InvoiceController extends Controller
{
    /**
     * عرض قائمة الفواتير
     */
    public function index()
    {
        $invoices = Invoice::with('project.client')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * عرض نموذج إنشاء فاتورة جديدة
     */
    public function create(Request $request, $projectId)
    {
        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم أو الموظف لديه صلاحيات Admin
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان الموظف جزءًا من فريق المشروع
        $isInProjectTeam = ProjectTeam::where('project_id', $projectId)
            ->where('employee_id', $currentEmployee->id)
            ->exists();

        // إذا لم يكن المستخدم Admin ولم يكن ضمن فريق المشروع، يتم منعه من إنشاء الفاتورة
        if (!$isAdmin && !$isInProjectTeam) {
            return redirect()->route('projects.show', $projectId)->with('error', 'ليس لديك صلاحية لإنشاء فاتورة لهذا المشروع.');
        }

        // جلب المشروع المحدد مع المصاريف غير المرتبطة بأي فاتورة
        $project = Project::with(['expenses' => function ($query) {
            $query->whereNull('invoice_id');
        }])->findOrFail($projectId);

        return view('invoices.create', compact('project'));
    }




    /**
     * حفظ الفاتورة الجديدة
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'total_amount' => 'nullable|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,Paid',
            'expense_ids' => 'nullable|array',
            'expense_ids.*' => 'nullable|exists:expenses,id',
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

        // إذا لم يكن المستخدم Admin ولم يكن ضمن فريق المشروع، يتم منعه من إنشاء الفاتورة
        if (!$isAdmin && !$isInProjectTeam) {
            return redirect()->route('projects.show', $request->project_id)
                ->with('error', 'ليس لديك صلاحية لإنشاء فاتورة لهذا المشروع.');
        }

        // إنشاء الفاتورة
        $invoice = Invoice::create([
            'project_id' => $request->project_id,
            'invoice_number' => 'INV-' . mt_rand(1000, 9999),
            'total_amount' => $request->total_amount ?? 0,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'amount_paid' => $request->status === 'Paid' ? ($request->total_amount ?? 0) : null,
            'payment_date' => $request->status === 'Paid' ? now() : null,
            'notes' => $request->notes,
            'created_by' => $currentEmployee->id, // إضافة حقل الكريتيد باي
        ]);

        // معالجة المصاريف المرتبطة بالفاتورة
        if ($request->has('expense_ids')) {
            // تصفية القيم الفارغة من `expense_ids`
            $validExpenseIds = array_filter($request->expense_ids);

            if (!empty($validExpenseIds)) {
                // جلب المصاريف الصحيحة فقط
                $expenses = Expense::whereIn('id', $validExpenseIds)->get();

                if ($expenses->isNotEmpty()) {
                    // تحديث مبلغ الفاتورة إذا لم يتم إدخاله يدويًا
                    if (!$request->filled('total_amount')) {
                        $invoice->update(['total_amount' => $expenses->sum('amount')]);
                    }

                    // ربط المصاريف بالفاتورة
                    Expense::whereIn('id', $validExpenseIds)->update(['invoice_id' => $invoice->id]);
                }
            }
        }

        return redirect()->route('projects.show', $request->project_id)
            ->with('success', 'تم إنشاء الفاتورة بنجاح.');
    }







    /**
     * عرض فاتورة معينة
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('expenses'); // تحميل المصاريف المرتبطة بالفاتورة
        return view('invoices.show', compact('invoice'));
    }

    /**
     * عرض نموذج تعديل الفاتورة
     */
    public function edit(Invoice $invoice)
    {
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';
        $isCreator = ($currentEmployee && $invoice->created_by === $currentEmployee->id);

        if (!$isAdmin && !$isCreator) {
            return redirect()->route('projects.show', $invoice->project_id)->with('error', 'ليس لديك صلاحية لتعديل هذه الفاتورة.');
        }

        $project = $invoice->project;
        $expenses = $project->expenses()->where(function ($query) use ($invoice) {
            $query->whereNull('invoice_id')
                ->orWhere('invoice_id', $invoice->id);
        })->get();

        $selectedExpenses = $invoice->expenses->pluck('id')->toArray();

        return view('invoices.edit', compact('invoice', 'project', 'expenses', 'selectedExpenses'));
    }


    /**
     * تحديث بيانات الفاتورة
     */
    public function update(Request $request, Invoice $invoice)
    {
        // جلب المستخدم الحالي والموظف المرتبط به
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        // التحقق مما إذا كان المستخدم Admin (إما عن طريق الموظف أو اليوزر)
        $isAdmin = ($currentEmployee && $currentEmployee->role === 'Admin') || $currentUser->role === 'Admin';

        // التحقق مما إذا كان المستخدم هو منشئ الفاتورة
        $isCreator = ($currentEmployee && $invoice->created_by === $currentEmployee->id);

        // التحقق مما إذا كان المستخدم لديه الصلاحية
        if (!$isAdmin && !$isCreator) {
            return redirect()->route('projects.show', $invoice->project_id)
                ->with('error', 'ليس لديك صلاحية لتعديل هذه الفاتورة.');
        }

        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,Paid,Overdue',
            'notes' => 'nullable|string',
            'expense_ids' => 'nullable|array',
            'expense_ids.*' => 'exists:expenses,id',
        ]);

        // تحديث بيانات الفاتورة
        $invoice->update($validatedData);

        // يمكنك استخدام project_id من الفاتورة بدلاً من الطلب
        $currentDate = now();
        $dueDate = $invoice->due_date;

        // تحديث الحالة بناءً على تاريخ الاستحقاق
        if ($currentDate->greaterThan($dueDate) && $request->status !== 'Paid') {
            $invoice->status = 'Overdue';
        } elseif ($request->status === 'Pending' && $currentDate->lessThanOrEqualTo($dueDate)) {
            $invoice->status = 'Pending';
        }

        // تعيين مبلغ السداد وتاريخ الدفع عند تغيير الحالة إلى "Paid"
        if ($request->status === 'Paid') {
            $invoice->amount_paid = $invoice->total_amount;
            $invoice->payment_date = $currentDate;
        } elseif ($request->status === 'Pending') {
            $invoice->amount_paid = null;
            $invoice->payment_date = null;
        }

        $invoice->save();

        // تحديث المصاريف المرتبطة بالفاتورة
        $selectedExpenseIds = $request->expense_ids ?? [];
        $validExpenseIds = array_filter($selectedExpenseIds);

        // إذا كان هناك مصاريف صالحة، قم بتحديث علاقة المصاريف بالفاتورة
        if (!empty($validExpenseIds)) {
            Expense::whereIn('id', $validExpenseIds)
                ->update(['invoice_id' => $invoice->id]);
        }

        return redirect()->route('projects.show', $invoice->project_id)
            ->with('success', 'تم تحديث الفاتورة بنجاح.');
    }





    /**
     * حذف الفاتورة
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
