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
            <a href="{{ route('leads.create') }}" class="btn btn-primary btn-round">Add New Lead</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Leads List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Assigned To</th>
                                    <th>Converted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Assigned To</th>
                                    <th>Converted At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($leads as $lead)
                                    <tr>
                                        <td>{{ $lead->name }}</td>
                                        <td>{{ $lead->email }}</td>
                                        <td>{{ $lead->phone }}</td>
                                        <td>{{ $lead->status }}</td>
                                        <td>{{ $lead->source }}</td>
                                        <td>{{ $lead->assigned_to }}</td>
                                        <td>{{ $lead->converted_at ? $lead->converted_at->format('Y-m-d H:i:s') : 'N/A' }}
                                        </td>
                                        <td>
                                            <!-- View Button -->
                                            <a href="{{ route('leads.show', $lead->id) }}"
                                                class="btn btn-info btn-sm">View</a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('leads.edit', $lead->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this lead?')">Delete</button>
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
