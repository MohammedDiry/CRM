@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Create New Project</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#"><i class="icon-home"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Projects</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Create</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Project Details</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Project Name -->
                                <div class="form-group">
                                    <label for="name">Project Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Enter project name" required />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Client Selection -->
                                <div class="form-group">
                                    <label for="client_id">Client</label>
                                    @if (isset($client))
                                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                                        <p class="form-control-plaintext"><strong>{{ $client->name }}</strong></p>
                                    @else
                                        <select class="form-control" id="client_id" name="client_id" required>
                                            <option value="">Select a client</option>
                                            @foreach ($clients as $clientOption)
                                                <option value="{{ $clientOption->id }}"
                                                    {{ old('client_id') == $clientOption->id ? 'selected' : '' }}>
                                                    {{ $clientOption->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>

                                <!-- Project Description -->
                                <div class="form-group">
                                    <label for="description">Project Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        placeholder="Enter project description" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Start Date -->
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ old('start_date') }}" required />
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ old('end_date') }}" required />
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Budget -->
                                <div class="form-group">
                                    <label for="budget">Budget</label>
                                    <input type="number" class="form-control" id="budget" name="budget"
                                        value="{{ old('budget') }}" placeholder="Enter project budget" step="0.01"
                                        required />
                                    @error('budget')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Project Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="On Hold" {{ old('status') == 'On Hold' ? 'selected' : '' }}>On Hold
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create Project</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
