<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;

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
        public function create()
        {
            $clients = Client::with('projects')->get();
            return view('invoices.create', compact('clients'));
        }

        /**
         * حفظ الفاتورة الجديدة
         */
        public function store(Request $request)
        {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'total_amount' => 'required|numeric|min:0',
                'due_date' => 'required|date',
                'status' => 'required|in:Pending,Paid,Overdue',
            ]);

            $project = Project::findOrFail($request->project_id);

            // إنشاء الفاتورة
            $invoice = Invoice::create([
                'project_id' => $request->project_id,
                'invoice_number' => 'INV-' . mt_rand(1000, 9999),
                'total_amount' => $request->total_amount,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'amount_paid' => $request->status === 'Paid' ? $request->total_amount : null,
                'payment_date' => $request->status === 'Paid' ? now() : null,
                'notes' => $request->notes,
            ]);

            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
        }

        /**
         * عرض فاتورة معينة
         */
        public function show(Invoice $invoice)
        {
            return view('invoices.show', compact('invoice'));
        }

        /**
         * عرض نموذج تعديل الفاتورة
         */
        public function edit(Invoice $invoice)
        {
            $clients = Client::with('projects')->get();
            return view('invoices.edit', compact('invoice', 'clients'));
        }

        /**
         * تحديث بيانات الفاتورة
         */
        public function update(Request $request, Invoice $invoice)
        {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'total_amount' => 'required|numeric|min:0',
                'due_date' => 'required|date',
                'status' => 'required|in:Pending,Paid,Overdue',
            ]);

            $invoice->update([
                'project_id' => $request->project_id,
                'total_amount' => $request->total_amount,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'amount_paid' => $request->status === 'Paid' ? $request->total_amount : null,
                'payment_date' => $request->status === 'Paid' ? now() : null,
                'notes' => $request->notes,
            ]);

            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
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


