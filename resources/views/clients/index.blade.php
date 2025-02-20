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
        <!-- Add Client Button -->
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('clients.create') }}" class="btn btn-primary btn-round">Add New Client</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Clients List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    <th>Assigned Employee</th> <!-- New Column -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    <th>Assigned Employee</th> <!-- New Column -->
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>{{ $client->company_name ?? 'N/A' }}</td>
                                        <td>{{ $client->address ?? 'N/A' }}</td>
                                        <td>{{ $client->assignedTo->name ?? 'N/A' }}</td> <!-- Display Employee Name -->
                                        <td>
                                            <button class="btn btn-info btn-sm">
                                                <a href="{{ route('clients.show', $client->id) }}"
                                                    class="text-white">View</a>
                                            </button>
                                            <button class="btn btn-primary btn-sm">
                                                <a href="{{ route('clients.edit', $client->id) }}"
                                                    class="text-white">Edit</a>
                                            </button>
                                            <form method="POST" action="{{ route('clients.destroy', $client->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this client?');">
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
