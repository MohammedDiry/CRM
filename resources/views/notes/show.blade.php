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

    <div class="container mt-4">
        <div class="row">
            <!-- Notes Section -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i> Notes</h5>
                        <!-- زر إضافة ملاحظة -->
                        <a href="{{ route('notes.create', ['noteableType' => 'client', 'noteableId' => $client->id]) }}"
                            class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Add Note
                        </a>
                    </div>
                    <div class="card-body">
                        @forelse ($client->notes as $note)
                            <div class="border p-3 rounded bg-light mb-2">
                                <p><strong>{{ $note->employee->name }}</strong>
                                    ({{ $note->created_at->format('d M Y H:i') }})</p>
                                <p><strong>Client: </strong>{{ $note->noteable->name ?? 'N/A' }}</p>
                                <p><strong>Company: </strong>{{ $note->noteable->company_name ?? 'N/A' }}</p>
                                <p>{{ $note->note }}</p>
                            </div>
                        @empty
                            <p class="text-muted">No notes available for this client.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
