@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Add New Lead</h3>
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
                <a href="#">Add New Lead</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add New Lead</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('leads.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Lead Name -->
                                <div class="form-group">
                                    <label for="name">Lead Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter lead name" required />
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter email address" required />
                                </div>

                                <!-- Phone Number -->
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter phone number" required />
                                </div>

                                <!-- Source -->
                                <div class="form-group">
                                    <label for="source">Source</label>
                                    <select class="form-control" id="source" name="source" required>
                                        <option value="Social Media">Social Media</option>
                                        <option value="Website">Website</option>
                                        <option value="Referral">Referral</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="New">New</option>
                                        <option value="Contacted">Contacted</option>
                                        <option value="Won">Won</option>
                                        <option value="Lost">Lost</option>
                                    </select>
                                </div>

                                <!-- Assigned To (Employee) -->
                                <div class="form-group">
                                    <label for="assigned_to">Assigned To</label>
                                    <select class="form-control" id="assigned_to" name="assigned_to" required>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save Lead</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
