@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Lead Information</h3>
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
                <a href="#">Leads</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Lead</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Lead Information</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('leads.update', $lead->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Lead Name -->
                                <div class="form-group">
                                    <label for="name">Lead Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $lead->name }}" placeholder="Enter lead name" required />
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $lead->email }}" placeholder="Enter email address" required />
                                </div>

                                <!-- Phone Number -->
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $lead->phone }}" placeholder="Enter phone number" required />
                                </div>

                                <!-- Source -->
                                <div class="form-group">
                                    <label for="source">Source</label>
                                    <select class="form-control" id="source" name="source" required>
                                        <option value="Social Media"
                                            {{ $lead->source === 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                        <option value="Website" {{ $lead->source === 'Website' ? 'selected' : '' }}>Website
                                        </option>
                                        <option value="Referral" {{ $lead->source === 'Referral' ? 'selected' : '' }}>
                                            Referral</option>
                                        <option value="Other" {{ $lead->source === 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="New" {{ $lead->status === 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Contacted" {{ $lead->status === 'Contacted' ? 'selected' : '' }}>
                                            Contacted</option>
                                        <option value="Won" {{ $lead->status === 'Won' ? 'selected' : '' }}>Won</option>
                                        <option value="Lost" {{ $lead->status === 'Lost' ? 'selected' : '' }}>Lost
                                        </option>
                                    </select>
                                </div>

                                <!-- Assigned To (Employee) -->
                                <div class="form-group">
                                    <label for="assigned_to">Assigned To</label>
                                    <select class="form-control" id="assigned_to" name="assigned_to" required>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ $lead->assigned_to === $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
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
