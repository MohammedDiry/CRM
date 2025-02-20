@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Create Project Team</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#"><i class="icon-home"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Projects</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Create Team</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add Team Members for Project: <strong>{{ $project->name }}</strong></div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('project-teams.store', $project->id) }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Select Employees -->
                                <div class="form-group">
                                    <label for="employee_ids">Select Employees</label>
                                    <select class="form-control" id="employee_ids" name="employee_ids[]" multiple required>
                                        <option value="">Select Employees</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ in_array($employee->id, old('employee_ids', [])) ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_ids')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Select Team Lead -->
                                <div class="form-group">
                                    <label for="team_lead_id">Select Team Lead (Optional)</label>
                                    <select class="form-control" id="team_lead_id" name="team_lead_id">
                                        <option value="">Select a Team Lead (Optional)</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ old('team_lead_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_lead_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Add Team Members</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
