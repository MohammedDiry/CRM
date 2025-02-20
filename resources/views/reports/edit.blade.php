@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Report</h3>
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
                <a href="#">Edit</a>
            </li>
        </ul>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Report</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('reports.update', $report->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- هذا السطر يستخدم لتحديد نوع الطلب كـ PUT -->

                <!-- Report Type -->
                <div class="mb-3">
                    <label for="report_type" class="form-label"><i class="fas fa-tag me-2"></i> Report Type</label>
                    <select name="report_type" id="report_type" class="form-select" required>
                        <option value="" disabled>Select a report type</option>
                        <option value="Financial" {{ $report->report_type == 'Financial' ? 'selected' : '' }}>Financial</option>
                        <option value="Project Summary" {{ $report->report_type == 'Project Summary' ? 'selected' : '' }}>Project Summary</option>
                        <option value="Performance" {{ $report->report_type == 'Performance' ? 'selected' : '' }}>Performance</option>
                    </select>
                </div>

                <!-- Related Project -->
                @if($report->project_id)
                <div class="mb-3">
                    <label for="project_id" class="form-label"><i class="fas fa-folder me-2"></i> Related Project</label>
                    <input type="text" class="form-control" value="{{ $projects->where('id', $report->project_id)->first()->name ?? 'Unknown Project' }}" disabled>
                    <input type="hidden" name="project_id" value="{{ $report->project_id }}">
                </div>
                @endif

                <!-- Report Content -->
                <div class="mb-3">
                    <label for="data" class="form-label"><i class="fas fa-file-alt me-2"></i> Report Content</label>
                    <textarea name="data" id="data" rows="5" class="form-control" placeholder="Write the report details..." required>{{ $report->data }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Report</button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
