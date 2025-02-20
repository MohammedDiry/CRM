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
            <a href="{{ route('reports.create') }}" class="btn btn-primary btn-round">Add General Report</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Reports List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Report Type</th>
                                    <th>Generated By</th>
                                    <th>Project</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Report Type</th>
                                    <th>Generated By</th>
                                    <th>Project</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>
                                            {{ $report->report_type }}
                                        </td>
                                        <td>{{ $report->generatedBy->name }}</td> <!-- تأكد من أن لديك علاقة مع المستخدم -->
                                        <td>
                                            {{ $report->project ? $report->project->name : 'General Report' }} <!-- عرض اسم المشروع أو "General Report" -->
                                        </td>
                                        <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm">
                                                <a href="{{ route('reports.show', $report->id) }}" class="text-white">View</a>
                                            </button>
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
