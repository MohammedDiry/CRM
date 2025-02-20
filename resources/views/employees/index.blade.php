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
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('employees.create') }}" class="btn btn-primary btn-round">Add New employee</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Employees List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>
                                            <span
                                                class="badge
                                                        @if ($employee->role == 'Admin') bg-danger
                                                        @elseif ($employee->role == 'Accountant') bg-warning
                                                        @else bg-success @endif">
                                                {{ $employee->role }}
                                            </span>
                                        </td>
                                        <td>
                                            <!-- View Button -->
                                            <a href="{{ route('employees.show', $employee->id) }}"
                                                class="btn btn-info btn-sm">
                                                View
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
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
