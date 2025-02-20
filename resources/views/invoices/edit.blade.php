@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Invoice</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#"><i class="icon-home"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Invoices</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Edit Invoice</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Invoice</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Project Name Display -->
                                <div class="form-group">
                                    <label for="project_name">Project</label>
                                    <input type="text" class="form-control" id="project_name"
                                        value="{{ $invoice->project->name }}" readonly />
                                    <input type="hidden" name="project_id" value="{{ $invoice->project_id }}">
                                </div>

                                <!-- Total Amount -->
                                <div class="form-group">
                                    <label for="total_amount">Total Amount</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount"
                                        value="{{ $invoice->total_amount }}" placeholder="Enter total amount" step="0.01"
                                        required />
                                </div>

                                <!-- Due Date -->
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date"
                                        value="{{ $invoice->due_date }}" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Invoice Status -->
                                <div class="form-group">
                                    <label for="status">Invoice Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Pending" {{ $invoice->status == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Paid" {{ $invoice->status == 'Paid' ? 'selected' : '' }}>Paid
                                        </option>
                                    </select>
                                </div>

                                <!-- Notes -->
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any additional notes">{{ $invoice->notes }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Expenses Selection Table -->
                        <div class="form-group mt-4">
                            <label class="fw-bold">Select Expenses</label>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Category</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm {{ in_array($expense->id, $selectedExpenses) ? 'btn-danger' : 'btn-primary' }} select-expense"
                                                        data-id="{{ $expense->id }}">
                                                        <i
                                                            class="fas {{ in_array($expense->id, $selectedExpenses) ? 'fa-times' : 'fa-check' }}"></i>
                                                        {{ in_array($expense->id, $selectedExpenses) ? 'Deselect' : 'Select' }}
                                                    </button>
                                                    <input type="hidden" name="expense_ids[]"
                                                        value="{{ in_array($expense->id, $selectedExpenses) ? $expense->id : '' }}"
                                                        class="expense-input">
                                                </td>
                                                <td>{{ $expense->category }}</td>
                                                <td>${{ number_format($expense->amount, 2) }}</td>
                                                <td>{{ $expense->description ?? 'No description' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle expense selection -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".select-expense").forEach(button => {
                button.addEventListener("click", function() {
                    let row = this.closest("tr");
                    let hiddenInput = row.querySelector(".expense-input");

                    if (hiddenInput.value) {
                        // إلغاء التحديد
                        hiddenInput.value = "";
                        this.classList.remove("btn-danger");
                        this.classList.add("btn-primary");
                        this.innerHTML = '<i class="fas fa-check"></i> Select';
                    } else {
                        // تحديد المصروف
                        hiddenInput.value = this.dataset.id;
                        this.classList.remove("btn-primary");
                        this.classList.add("btn-danger");
                        this.innerHTML = '<i class="fas fa-times"></i> Deselect';
                    }
                });
            });
        });
    </script>
@endsection
