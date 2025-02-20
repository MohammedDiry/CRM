@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">DataTables.Net</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tables</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Datatables</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Invoices List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Date</th>
                                    <th>Notes</th>
                                    <th>Client Name</th>
                                    <th>Created By</th> <!-- حقل جديد لعرض اسم الموظف الذي أنشأ الفاتورة -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Date</th>
                                    <th>Notes</th>
                                    <th>Client Name</th>
                                    <th>Created By</th> <!-- حقل جديد في الفوتر -->
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->total_amount }}</td>
                                        <td>{{ $invoice->status }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->amount_paid ?? 'N/A' }}</td>
                                        <td>{{ $invoice->payment_date ?? 'N/A' }}</td>
                                        <td>{{ $invoice->notes ?? 'N/A' }}</td>
                                        <td>
                                            @if ($invoice->project && $invoice->project->client)
                                                {{ $invoice->project->client->name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($invoice->created_by)
                                                {{ $invoice->created_by->name }} <!-- عرض اسم الموظف الذي أنشأ الفاتورة -->
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm">
                                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                                    class="text-white">View</a>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
