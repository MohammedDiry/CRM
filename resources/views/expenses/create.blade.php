@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Create Expense</h3>
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
                <a href="#">Expenses</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Create Expense</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add New Expense</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Display Project Name (read-only) -->
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <input type="text" class="form-control" value="{{ $project->name }}" readonly />
                                    <!-- Hidden Input for project_id -->
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                </div>

                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="Advertising">Advertising</option>
                                        <option value="Software">Software</option>
                                        <option value="Salaries">Salaries</option>
                                        <option value="Miscellaneous">Miscellaneous</option>
                                    </select>
                                </div>

                                <!-- Amount -->
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        placeholder="Enter amount" step="0.01" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">


                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        placeholder="Enter description (optional)"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Add Expense</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
