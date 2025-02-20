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
            <!-- Project Information Card -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-project-diagram me-2"></i> Project Details</h5>
                        <form action="{{ route('projects.edit', $project->id) }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-tasks me-2"></i> Project Name:</strong> {{ $project->name }}</p>
                                <p><strong><i class="fas fa-align-left me-2"></i> Description:</strong>
                                    {{ $project->description ?? 'No description available' }}</p>
                                <p><strong><i class="fas fa-calendar-alt me-2"></i> Start Date:</strong>
                                    {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</p>
                                <p><strong><i class="fas fa-calendar-check me-2"></i> End Date:</strong>
                                    {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : 'Ongoing' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-money-bill-alt me-2"></i> Budget:</strong>
                                    ${{ number_format($project->budget, 2) }}</p>
                                <p><strong><i class="fas fa-cogs me-2"></i> Status:</strong> <span
                                        class="badge bg-success">{{ $project->status }}</span></p>
                                <p><strong><i class="fas fa-user-tie me-2"></i> Team Lead:</strong>
                                    @if ($project->team->isNotEmpty())
                                        {{ $project->team->firstWhere('pivot.team_lead_id', $project->team_lead_id)->name ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Team Table -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title"><i class="fas fa-users me-2"></i> Project Team</h4>
                        @if ($project->projectTeam && $project->projectTeam->count() > 0)
                            <a href="{{ route('project-teams.edit', ['project' => $project->id, 'team' => optional($project->projectTeam->first())->id]) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-2"></i> Edit Team
                            </a>
                        @else
                            <a href="{{ route('project-teams.create', $project->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i> Create Team
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($project->projectTeam->count() > 0)
                            <h5>Team Lead:
                                @php
                                    $teamLead = $project->projectTeam->whereNotNull('team_lead_id')->first();
                                @endphp
                                {{ $teamLead && $teamLead->team_lead_id ? optional($teamLead->teamLead)->name : 'Not Assigned' }}
                            </h5>

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Assigned Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->projectTeam as $member)
                                        <tr>
                                            <td>{{ optional($member->employee)->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($member->assigned_date)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No team assigned for this project yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Employee Ratings Table -->
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
                                        <th>Employee Name</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->projectTeam as $member)
                                        @php
                                            $rating = $member->employee->employeeRatings
                                                ->where('project_id', $project->id)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $member->employee->name }}</td>
                                            <td>
                                                @if ($rating)
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="fas fa-star {{ $i <= $rating->rating ? 'text-warning' : 'text-muted' }}"></span>
                                                    @endfor
                                                @else
                                                    <span class="text-muted">No rating yet</span>
                                                @endif
                                            </td>
                                            <td>{{ $rating ? $rating->review : 'No review yet' }}</td>
                                            <td>
                                                @if (!$rating)
                                                    <a href="{{ route('employee_ratings.create', ['project' => $project->id, 'employee' => $member->employee->id]) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-star"></i> Add Rating
                                                    </a>
                                                @else
                                                    <a href="{{ route('employee_ratings.edit', ['rating' => $rating->id]) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit Rating
                                                    </a>
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

            <!-- Project Invoices Table -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-file-invoice-dollar me-2"></i> Project Invoices</h4>
                        <a href="{{ route('invoices.create', $project->id) }}" class="btn btn-success btn-sm float-end">
                            <i class="fas fa-plus-circle me-2"></i> Add Invoice
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Total Amount</th>
                                        <th>Due Date</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>Created By</th> <!-- حقل جديد لعرض اسم المنشئ -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>#{{ $invoice->invoice_number }}</td>
                                            <td>${{ number_format($invoice->total_amount, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
                                            <td>
                                                @if ($invoice->payment_date)
                                                    {{ \Carbon\Carbon::parse($invoice->payment_date)->format('d M Y') }}
                                                @else
                                                    <span class="text-danger">Not Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge
                                                    @if ($invoice->status === 'Paid') bg-success
                                                    @elseif ($invoice->status === 'Overdue') bg-danger
                                                    @else bg-warning @endif">
                                                    {{ $invoice->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($invoice->created_by)
                                                    {{ $invoice->created_by->name }}
                                                    <!-- عرض اسم الموظف الذي أنشأ الفاتورة -->
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i> Delete
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

            <!-- Project Expenses Table -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title"><i class="fas fa-money-bill-wave me-2"></i> Project Expenses</h4>
                        <a href="{{ route('expenses.create', ['project_id' => $project->id]) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i> Add Expense
                        </a>
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
                                        <th>Added By</th> <!-- حقل جديد لعرض من أضاف المصروف -->
                                        <th>Invoice Number</th> <!-- حقل جديد لرقم الفاتورة -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($project->expenses as $expense)
                                        <tr>
                                            <td>{{ $expense->category }}</td>
                                            <td>${{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ $expense->description ?? 'No description' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('d M Y') }}</td>
                                            <td>{{ $expense->credited_by ? $expense->credited_by->name : 'N/A' }}</td>
                                            <!-- عرض اسم من أضاف المصروف -->
                                            <td>{{ $expense->invoice_id ? $expense->invoice->number : 'N/A' }}</td>
                                            <!-- عرض رقم الفاتورة إذا كان موجودًا -->
                                            <td>
                                                <a href="{{ route('expenses.edit', $expense->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('expenses.destroy', $expense->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No expenses recorded for this project.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Reports Table -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title"><i class="fas fa-file-alt me-2"></i> Project Reports</h4>
                        <a href="{{ route('reports.create', ['project_id' => $project->id]) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i> Add Report
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Report Type</th>
                                        <th>Generated By</th>
                                        <th>Role</th>
                                        <th>Project Role</th>
                                        <th>Date Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($project->reports as $report)
                                        @php
                                            $employee = $report->generatedBy; // الموظف الذي كتب التقرير
                                            $projectRole = $project->projectTeam
                                                ->where('employee_id', $employee->id)
                                                ->first();
                                            $isTeamLead = $projectRole && $projectRole->team_lead_id == $employee->id;
                                        @endphp
                                        <tr>
                                            <td>{{ $report->report_type }}</td>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ ucfirst($employee->role) }}</td>
                                            <td>
                                                <span class="badge {{ $isTeamLead ? 'bg-danger' : 'bg-info' }}">
                                                    {{ $isTeamLead ? 'Team Lead' : 'Member' }}
                                                </span>
                                            </td>
                                            <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('reports.show', $report->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('reports.edit', $report->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-muted text-center">No reports available for
                                                this project.</td>
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
