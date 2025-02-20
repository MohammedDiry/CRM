@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Create New Employee</h3>
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
                <a href="#">Create Employee</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Create New Employee</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Employee Name -->
                                <div class="form-group">
                                    <label for="name">Employee Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter employee name" required />
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

                                <!-- Employee Role -->
                                <div class="form-group">
                                    <label for="role">Employee Role</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="Admin">Admin</option>
                                        <option value="CSR">CSR</option>
                                        <option value="Accountant">Accountant</option>
                                        <option value="Employee">Employee</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter password" required />
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create Employee</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
