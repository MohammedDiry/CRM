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
                    <div class="card-title">Add Note</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf
                        <input type="hidden" name="noteableType" value="{{ $noteableType }}">
                        <input type="hidden" name="noteableId" value="{{ $noteableId }}">

                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" name="note" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
