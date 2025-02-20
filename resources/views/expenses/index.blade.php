@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Expenses Management</h3>
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
                <a href="#">Expenses</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">List</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Expenses List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Added By</th> <!-- حقل جديد لعرض من أضاف المصروف -->
                                    <th>Invoice Number</th> <!-- حقل جديد لرقم الفاتورة -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Added By</th> <!-- حقل جديد لعرض من أضاف المصروف -->
                                    <th>Invoice Number</th> <!-- حقل جديد لرقم الفاتورة -->
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->project->name }}</td>
                                        <td>{{ $expense->category }}</td>
                                        <td>${{ number_format($expense->amount, 2) }}</td>
                                        <td>{{ $expense->description ?? 'N/A' }}</td>
                                        <td>{{ $expense->created_at }}</td>
                                        <td>{{ $expense->credited_by ? $expense->credited_by->name : 'N/A' }}</td>
                                        <!-- عرض اسم من أضاف المصروف -->
                                        <td>{{ $expense->invoice_id ? $expense->invoice->number : 'N/A' }}</td>
                                        <!-- عرض رقم الفاتورة إذا كان موجودًا -->
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
