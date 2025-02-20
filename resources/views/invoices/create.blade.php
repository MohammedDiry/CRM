@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Create Invoice</h3>
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
                <a href="#">Invoices</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Create</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Create Invoice</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invoices.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Project Name Display -->
                                <div class="form-group">
                                    <label for="project_name">Project</label>
                                    <input type="text" class="form-control" id="project_name"
                                        value="{{ $project->name }}" readonly />
                                </div>
                                <!-- Project ID Hidden Field -->
                                <input type="hidden" name="project_id" value="{{ $project->id }}" />

                                <!-- Total Amount -->
                                <div class="form-group">
                                    <label for="total_amount">Total Amount</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount"
                                        placeholder="Enter total amount" step="0.01" required />
                                </div>

                                <!-- Due Date -->
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Invoice Status -->
                                <div class="form-group">
                                    <label for="status">Invoice Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>

                                <!-- Notes -->
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any additional notes"></textarea>
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
                                        @foreach ($project->expenses as $expense)
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary select-expense"
                                                        data-id="{{ $expense->id }}">
                                                        <i class="fas fa-check"></i> Select
                                                    </button>
                                                    <input type="hidden" name="expense_ids[]" value=""
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
                            <button type="submit" class="btn btn-success">Create Invoice</button>
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
