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
            <a href="{{ route('projects.create') }}" class="btn btn-primary btn-round">Add New Project</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Projects List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Client</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Budget</th>
                                    <th>Status</th>
                                    <th>Team Lead</th> <!-- العمود الجديد -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Client</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Budget</th>
                                    <th>Status</th>
                                    <th>Team Lead</th> <!-- العمود الجديد -->
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->client->name }}</td>
                                        <td>{{ $project->start_date }}</td>
                                        <td>{{ $project->end_date ?? 'Ongoing' }}</td>
                                        <td>${{ number_format($project->budget, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge
                                                @if ($project->status == 'Ongoing') badge-primary
                                                @elseif($project->status == 'Completed') badge-success
                                                @else badge-warning @endif">
                                                {{ $project->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($project->team->isNotEmpty())
                                                {{ $project->team->firstWhere('pivot.team_lead_id', $project->team_lead_id)->name ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <!-- View Project Button -->
                                            <a href="{{ route('projects.show', $project->id) }}"
                                                class="btn btn-info btn-sm">
                                                View
                                            </a>

                                            <!-- Edit Project Button -->
                                            <a href="{{ route('projects.edit', $project->id) }}"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>

                                            <!-- Delete Project Button -->
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this project?');">
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
