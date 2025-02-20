@extends('layouts.app1')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Add Employee Rating</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#"><i class="icon-home"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Projects</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Add Rating</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add Rating for Employee in Project: <strong>{{ $project->name }}</strong></div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('employee_ratings.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <!-- عرض اسم الموظف الذي تم تحديده -->
                                <div class="form-group">
                                    <label for="employee_name">Employee</label>
                                    <input type="text" class="form-control" value="{{ $employee->name }}" readonly>
                                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                </div>

                                <!-- Rating -->
                                <div class="form-group">
                                    <label for="rating">Rating (1 to 5)</label>
                                    <select class="form-control" id="rating" name="rating" required>
                                        <option value="">Select Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('rating')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Review -->
                                <div class="form-group">
                                    <label for="review">Review</label>
                                    <textarea class="form-control" id="review" name="review" rows="4" required>{{ old('review') }}</textarea>
                                    @error('review')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- إضافة hidden field للمشروع -->
                                <input type="hidden" name="project" value="{{ $project->id }}">
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                                </div>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection
