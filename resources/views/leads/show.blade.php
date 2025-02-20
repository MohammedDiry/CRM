@extends('layouts.app1')
@section('content')
    <!-- Client Information Card -->
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Lead Details</h5>
                <form action="{{ route('leads.edit', $lead->id) }}" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-light btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-user me-2"></i> Name:</strong> {{ $lead->name }}</p>
                        <p><strong><i class="fas fa-envelope me-2"></i> Email:</strong> {{ $lead->email }}</p>
                        <p><strong><i class="fas fa-phone me-2"></i> Phone:</strong> {{ $lead->phone }}</p>
                        <p><strong><i class="fas fa-calendar-alt me-2"></i> Status:</strong>
                            <span
                                class="badge bg-{{ $lead->status === 'Won' ? 'success' : ($lead->status === 'Lost' ? 'danger' : 'warning') }}">
                                {{ $lead->status }}
                            </span>
                        </p>
                        <p><strong><i class="fas fa-calendar-check me-2"></i> Converted On:</strong>
                            {{ $lead->converted_at ? \Carbon\Carbon::parse($lead->converted_at)->format('d M Y') : 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-user-plus me-2"></i> Assigned To:</strong>
                            {{ $lead->assignedTo->name ?? 'N/A' }}</p>
                        <p><strong><i class="fas fa-share-alt me-2"></i> Source:</strong> {{ $lead->source }}</p>
                        <p><strong><i class="fas fa-clock me-2"></i> Added On:</strong>
                            {{ $lead->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes & Comments -->
    <div class="col-md-12 mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i> Notes & Comments</h5>
                <a href="{{ route('notes.create', ['noteableType' => 'leads', 'noteableId' => $lead->id]) }}"
                    class="btn btn-primary">
                    Add Note
                </a>
            </div>
            <div class="card-body">
                @forelse ($notes as $note)
                    <div class="border p-3 rounded bg-light mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p><strong>{{ $note->employee->name }}</strong>
                                    ({{ $note->created_at->format('d M Y H:i') }})</p>
                                <p>{{ $note->note }}</p>
                            </div>

                            @if (auth()->user()->employee->id === $note->employee_id || auth()->user()->isAdmin())
                                <div class="d-flex">
                                    <!-- زر التعديل -->
                                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- زر الحذف -->
                                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No notes available.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
