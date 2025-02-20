@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Invoice Details</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Invoices</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Invoice Details</a></li>
        </ul>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Invoice Details Card -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i> Invoice Details</h5>
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-file-invoice me-2"></i> Invoice Number:</strong>
                                    #{{ $invoice->invoice_number }}</p>
                                <p><strong><i class="fas fa-building me-2"></i> Client Name:</strong>
                                    {{ $invoice->project->client->name }}</p>
                                <p><strong><i class="fas fa-building me-2"></i> Company:</strong>
                                    {{ $invoice->project->client->company_name ?? 'N/A' }}</p>
                                <p><strong><i class="fas fa-calendar-alt me-2"></i> Due Date:</strong>
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</p>
                                <p><strong><i class="fas fa-cogs me-2"></i> Project Name:</strong>
                                    {{ $invoice->project->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-dollar-sign me-2"></i> Total Amount:</strong>
                                    ${{ number_format($invoice->total_amount, 2) }}</p>
                                <p><strong><i class="fas fa-check-circle me-2"></i> Status:</strong>
                                    <span
                                        class="badge
                                    @if ($invoice->status === 'Paid') bg-success
                                    @elseif ($invoice->status === 'Overdue') bg-danger
                                    @else bg-warning @endif">
                                        {{ $invoice->status }}
                                    </span>
                                </p>
                                <p><strong><i class="fas fa-calendar-check me-2"></i> Payment Date:</strong>
                                    @if ($invoice->payment_date)
                                        {{ \Carbon\Carbon::parse($invoice->payment_date)->format('d M Y') }}
                                    @else
                                        <span class="text-danger">Not Paid</span>
                                    @endif
                                </p>
                                <p><strong><i class="fas fa-user me-2"></i> Created By:</strong>
                                    {{ $invoice->createdBy->name ?? 'N/A' }}</p> <!-- عرض اسم المنشئ -->
                            </div>
                        </div>

                        <div class="d-flex mt-4">
                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Expenses Table -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title"><i class="fas fa-money-bill-wave me-2"></i> Invoice Expenses</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoice->expenses as $expense)
                                        <tr>
                                            <td>{{ $expense->category }}</td>
                                            <td>${{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ $expense->description ?? 'No description' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No expenses recorded for this invoice.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
