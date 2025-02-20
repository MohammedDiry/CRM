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


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Project</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('projects.update', $project->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Project Name -->
                                <div class="form-group">
                                    <label for="name">Project Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $project->name }}" placeholder="Enter project name" required />
                                </div>

                                <!-- Client Selection -->
                                <div class="form-group">
                                    <label for="client_id">Client</label>
                                    <select class="form-control" id="client_id" name="client_id" required>
                                        <option value="">Select a client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Project Description -->
                                <div class="form-group">
                                    <label for="description">Project Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        placeholder="Enter project description" required>{{ $project->description }}</textarea>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ $project->start_date }}" required />
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ $project->end_date }}" required />
                                </div>

                                <!-- Budget -->
                                <div class="form-group">
                                    <label for="budget">Budget</label>
                                    <input type="number" class="form-control" id="budget" name="budget"
                                        value="{{ $project->budget }}" placeholder="Enter project budget" step="0.01"
                                        required />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Project Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Active" {{ $project->status == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Completed" {{ $project->status == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="On Hold" {{ $project->status == 'On Hold' ? 'selected' : '' }}>On
                                            Hold</option>
                                    </select>
                                </div>


                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
