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

    <div class="container">
        <h4>Edit Note</h4>
        <form method="POST" action="{{ route('notes.update', $note->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" name="note" required>{{ $note->note }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Update Note</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
