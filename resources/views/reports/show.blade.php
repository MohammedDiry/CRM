@extends('layouts.app1')
@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Project Report Details</h3>
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
            <a href="#">Reports</a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="#">Project Report Details</a>
        </li>
    </ul>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i> Report Details</h5>
                    <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag me-2"></i> Report ID:</strong> #{{ $report->id }}</p>
                            <p><strong><i class="fas fa-cogs me-2"></i> Project Name:</strong> {{ $report->project ? $report->project->name : 'General Report' }}</p>
                            <p><strong><i class="fas fa-user-tie me-2"></i> Client Name:</strong> {{ $report->project ? $report->project->client->name : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user me-2"></i> Reported By:</strong> {{ $report->generatedBy->name }}</p>
                            <p><strong><i class="fas fa-calendar-alt me-2"></i> Created At:</strong> {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5><i class="fas fa-align-left me-2"></i> Report Content</h5>
                        <p class="border p-3 bg-light">{{ $report->data }}</p>
                    </div>

                    <div class="d-flex mt-4">
                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this report?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
