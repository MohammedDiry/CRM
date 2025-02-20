@extends('layouts.app1')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Expense</h3>
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
                <a href="#">Edit Expense</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Update Expense</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('expenses.update', $expense->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- Display Project Name -->
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <input type="text" class="form-control" id="project_id"
                                        value="{{ $expense->project->name }}" readonly />
                                    <input type="hidden" name="project_id" value="{{ $expense->project_id }}" />
                                </div>

                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="Advertising"
                                            {{ $expense->category == 'Advertising' ? 'selected' : '' }}>Advertising</option>
                                        <option value="Software" {{ $expense->category == 'Software' ? 'selected' : '' }}>
                                            Software</option>
                                        <option value="Salaries" {{ $expense->category == 'Salaries' ? 'selected' : '' }}>
                                            Salaries</option>
                                        <option value="Miscellaneous"
                                            {{ $expense->category == 'Miscellaneous' ? 'selected' : '' }}>Miscellaneous
                                        </option>
                                    </select>
                                </div>

                                <!-- Amount -->
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        value="{{ $expense->amount }}" placeholder="Enter amount" step="0.01" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">


                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        placeholder="Enter description (optional)">{{ $expense->description }}</textarea>
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
