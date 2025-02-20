@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Employee Information</h3>
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
                <a href="#">Employees</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Employee</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Employee Information</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('employees.update', $employee->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Employee Name -->
                                <div class="form-group">
                                    <label for="name">Employee Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $employee->name }}" placeholder="Enter employee name" required />
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $employee->email }}" placeholder="Enter email address" required />
                                </div>

                                <!-- Phone Number -->
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $employee->phone }}" placeholder="Enter phone number" required />
                                </div>

                                <!-- Employee Role -->
                                <div class="form-group">
                                    <label for="role">Employee Role</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="Admin" {{ $employee->role == 'Admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="Admin" {{ $employee->role == 'CSR' ? 'selected' : '' }}>CSR</option>
                                        <option value="Accountant" {{ $employee->role == 'Accountant' ? 'selected' : '' }}>
                                            Accountant</option>
                                        <option value="Employee" {{ $employee->role == 'Employee' ? 'selected' : '' }}>
                                            Employee</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Password (only for editing if needed) -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Leave blank to keep current password" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" />
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
