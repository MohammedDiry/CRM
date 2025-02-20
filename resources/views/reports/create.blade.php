@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Create New Report</h3>
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
                <a href="#">Create</a>
            </li>
        </ul>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Create New Report</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('reports.store') }}" method="POST">
                @csrf

                <!-- Report Type -->
                <div class="mb-3">
                    <label for="report_type" class="form-label"><i class="fas fa-tag me-2"></i> Report Type</label>
                    <select name="report_type" id="report_type" class="form-select" required>
                        <option value="" disabled selected>Select a report type</option>
                        <option value="Financial">Financial</option>
                        <option value="Project Summary">Project Summary</option>
                        <option value="Performance">Performance</option>
                    </select>
                </div>

                <!-- Related Project -->
                @if($selectedProjectId)
                <div class="mb-3">
                    <label for="project_id" class="form-label"><i class="fas fa-folder me-2"></i> Related Project</label>
                    <input type="text" class="form-control" value="{{ $projects->where('id', $selectedProjectId)->first()->name ?? 'Unknown Project' }}" disabled>
                    <input type="hidden" name="project_id" value="{{ $selectedProjectId }}">
                </div>
                @endif



                <!-- Report Content -->
                <div class="mb-3">
                    <label for="data" class="form-label"><i class="fas fa-file-alt me-2"></i> Report Content</label>
                    <textarea name="data" id="data" rows="5" class="form-control" placeholder="Write the report details..." required></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Report</button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
