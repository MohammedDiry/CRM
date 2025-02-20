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
                    <div class="card-title">Add New Client</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clients.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Client Name -->
                                <div class="form-group">
                                    <label for="name">Client Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter client name" required />
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

                                <!-- Company Name (Optional) -->
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        placeholder="Enter company name (optional)" />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <!-- Address -->
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address"></textarea>
                                </div>


                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save Client</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
