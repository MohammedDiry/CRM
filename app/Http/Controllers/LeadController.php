<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Employee;

class LeadController extends Controller
{
        // عرض جميع العملاء المحتملين
        public function index()
        {
            $leads = Lead::all();
            return view('leads.index', compact('leads'));
        }

        // عرض نموذج إضافة عميل محتمل جديد
        public function create()
        {
            $employees = Employee::all(); // لاستعراض الموظفين المعينين للمتابعة
            return view('leads.create', compact('employees'));
        }

        // تخزين عميل محتمل جديد في قاعدة البيانات
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:leads,email',
                'phone' => 'required|string|max:15',
                'assigned_to' => 'required|exists:employees,id', // تحقق من وجود الموظف في قاعدة البيانات
            ]);

            Lead::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => 'New', // الافتراضي
                'source' => $request->source,
                'assigned_to' => $request->assigned_to,
                'notes' => $request->notes,
            ]);

            return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
        }

        // عرض نموذج تعديل بيانات العميل المحتمل
        public function edit(Lead $lead)
        {
            $employees = Employee::all(); // لاستعراض الموظفين المعينين للمتابعة
            return view('leads.edit', compact('lead', 'employees'));
        }

        // تحديث بيانات العميل المحتمل في قاعدة البيانات
        public function update(Request $request, Lead $lead)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:leads,email,' . $lead->id,
                'phone' => 'required|string|max:15',
                'assigned_to' => 'required|exists:employees,id',
            ]);

            $lead->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'source' => $request->source,
                'assigned_to' => $request->assigned_to,
                'notes' => $request->notes,
            ]);

            return redirect()->route('leads.index')->with('success', 'Lead updated successfully!');
        }

        // حذف العميل المحتمل من قاعدة البيانات
        public function destroy(Lead $lead)
        {
            $lead->delete();
            return redirect()->route('leads.index')->with('success', 'Lead deleted successfully!');
        }
}
