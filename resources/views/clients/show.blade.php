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
            <!-- Client Information Card -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Client Details</h5>
                        <form action="{{ route('clients.edit', $client->id) }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-user me-2"></i> Name:</strong> {{ $client->name }}</p>
                                <p><strong><i class="fas fa-envelope me-2"></i> Email:</strong> {{ $client->email }}</p>
                                <p><strong><i class="fas fa-phone me-2"></i> Phone:</strong> {{ $client->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-building me-2"></i> Company:</strong>
                                    {{ $client->company_name ?? 'N/A' }}</p>
                                <p><strong><i class="fas fa-map-marker-alt me-2"></i> Address:</strong>
                                    {{ $client->address ?? 'N/A' }}</p>
                                <p><strong><i class="fas fa-calendar-alt me-2"></i> Added On:</strong>
                                    {{ $client->created_at->format('d M Y') }}</p>
                                <p><strong><i class="fas fa-user-plus me-2"></i> Added By:</strong>
                                    {{ $client->addedBy ? $client->addedBy->name : 'Unknown' }}
                                </p>
                                <p><strong><i class="fas fa-user-tie me-2"></i> Assigned Employee:</strong>
                                    {{ $client->assignedTo ? $client->assignedTo->name : 'N/A' }}
                                </p> <!-- New Field for Assigned Employee -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Projects Table -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title"><i class="fas fa-tasks me-2"></i> Client Projects</h4>

                        <!-- زر إضافة مشروع جديد -->
                        <a href="{{ route('projects.create', ['client_id' => $client->id]) }}"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Project
                        </a>
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
                                        <th>Project Manager</th> <!-- تغيير العنوان ليعكس أنه قائد الفريق -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->projects as $project)
                                        <tr>
                                            <td>{{ $project->name }}</td>
                                            <td><span class="badge bg-success">{{ $project->status }}</span></td>
                                            <td>{{ $project->start_date }}</td>
                                            <td>{{ $project->end_date ?? 'Ongoing' }}</td>
                                            <td>
                                                @if ($project->team->isNotEmpty())
                                                    {{ $project->team->firstWhere('pivot.team_lead_id', $project->team_lead_id)->name ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <!-- View Project -->
                                                <a href="{{ route('projects.show', $project->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>

                                                <!-- Edit Project -->
                                                <a href="{{ route('projects.edit', $project->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <!-- Delete Project -->
                                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this project?');">
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


            <!-- Invoices Table -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-file-invoice-dollar me-2"></i> Client Invoices</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Project</th>
                                        <th>Total Amount</th>
                                        <th>Due Date</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>Created By</th> <!-- إضافة عمود "Created By" -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->projects as $project)
                                        @foreach ($project->invoices as $invoice)
                                            <tr>
                                                <td>#{{ $invoice->invoice_number }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>${{ number_format($invoice->total_amount, 2) }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') ?? 'N/A' }}
                                                </td>
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
                                                <td>{{ $invoice->createdBy->name ?? 'N/A' }}</td> <!-- عرض اسم المنشئ -->
                                                <td>
                                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Notes & Comments -->
            <!-- Notes & Comments -->
            <div class="col-md-12 mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i> Notes & Comments</h5>
                        <a href="{{ route('notes.create', ['noteableType' => 'clients', 'noteableId' => $client->id]) }}"
                            class="btn btn-primary">
                            Add Note
                        </a>
                    </div>
                    <div class="card-body">
                        @forelse ($client->notes as $note)
                            <div class="border p-3 rounded bg-light mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p><strong>{{ $note->employee->name }}</strong>
                                            ({{ $note->created_at->format('d M Y H:i') }})</p>
                                        <p>{{ $note->note }}</p>
                                    </div>

                                    @if (auth()->user()->employee->id === $note->employee_id || auth()->user()->isAdmin())
                                        <div class="d-flex">
                                            <!-- زر التعديل -->
                                            <a href="{{ route('notes.edit', $note->id) }}"
                                                class="btn btn-sm btn-warning me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- زر الحذف -->
                                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this note?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No notes available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endsection
