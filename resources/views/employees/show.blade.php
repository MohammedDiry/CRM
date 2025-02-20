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


    <div class="container mt-4">
        <div class="row">
            <!-- Employee Information Card -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Employee Details</h5>
                        <form action="{{ route('employees.edit', $employee->id) }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-user me-2"></i> Name:</strong> {{ $employee->name }}</p>
                                <p><strong><i class="fas fa-envelope me-2"></i> Email:</strong> {{ $employee->email }}</p>
                                <p><strong><i class="fas fa-phone me-2"></i> Phone:</strong> {{ $employee->phone }}</p>
                                <p><strong><i class="fas fa-user-tie me-2"></i> Role:</strong> {{ $employee->role }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-calendar-alt me-2"></i> Joined On:</strong>
                                    {{ $employee->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Handled by Employee -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-tasks me-2"></i> Projects Handled</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Assigned Date</th> <!-- إضافة العمود Assigned Date -->
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->projects as $project)
                                        <tr>
                                            <td>{{ $project->name }}</td>
                                            <td><span class="badge bg-success">{{ $project->status }}</span></td>
                                            <td>{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</td>
                                            <td>{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : 'Ongoing' }}
                                            </td>
                                            <td>
                                                @if ($project->pivot->assigned_date)
                                                    {{ \Carbon\Carbon::parse($project->pivot->assigned_date)->format('d M Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($project->pivot->team_lead_id == $employee->id)
                                                    <span class="badge bg-warning">Team Lead</span>
                                                @else
                                                    <span class="badge bg-info">Member</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Reports Generated by Employee -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-file-alt me-2"></i> Reports Generated</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Report Type</th>
                                        <th>Generated On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->reports as $report)
                                        <tr>
                                            <td>{{ $report->report_type }}</td>
                                            <td>{{ $report->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('reports.show', $report->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leads Managed by Employee -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-users me-2"></i> Leads Managed</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Assigned Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- عرض الـ Leads فقط التي تخص هذا الموظف -->
                                    @foreach ($employee->leads as $lead)
                                        <tr>
                                            <td>{{ $lead->name }}</td>
                                            <td>{{ $lead->email }}</td>
                                            <td>{{ $lead->phone }}</td>
                                            <td>
                                                <span
                                                    class="badge
                                                        @if ($lead->status == 'Won') bg-success
                                                        @elseif ($lead->status == 'Lost') bg-danger
                                                        @else bg-warning @endif">
                                                    {{ $lead->status }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clients Managed by Employee -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-users me-2"></i> Clients Managed</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th>Assigned Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- عرض العملاء فقط الذين تخص هذا الموظف -->
                                    @foreach ($employee->assignedClient as $client)
                                        <tr>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->company_name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($client->created_at)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Employee Ratings -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-star me-2"></i> Employee Ratings</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Rated On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->employeeRatings as $rating)
                                        <tr>
                                            <td>{{ $rating->project->name }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star @if ($i <= $rating->rating) text-warning @else text-muted @endif"></i>
                                                @endfor
                                            </td>
                                            <td>{{ $rating->review }}</td>
                                            <td>{{ $rating->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
