@extends('layouts.editor')
@section('title', 'Review Paper')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Review Paper</h2>
    <a href="{{ route('editor.papers.index') }}" class="btn btn-secondary">Back to Papers</a>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header"><strong>Paper Details</strong></div>
            <div class="card-body">
                <h4>{{ $paper->title }}</h4>
                <p class="text-muted"><strong>Keywords:</strong> {{ $paper->keywords ?? 'N/A' }}</p>
                <hr>
                <h6>Abstract</h6>
                <p>{{ $paper->abstract }}</p>
                @if($paper->document_path)
                <a href="{{ asset('storage/' . $paper->document_path) }}" class="btn btn-outline-primary" target="_blank">
                    <i class="fas fa-download me-1"></i> Download Document
                </a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Reviews</strong></div>
            <div class="card-body">
                @forelse($paper->reviews as $review)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $review->user->name ?? 'Anonymous Reviewer' }}</strong>
                        <span class="badge bg-{{ $review->recommendation == 'accept' ? 'success' : ($review->recommendation == 'reject' ? 'danger' : 'warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $review->recommendation ?? 'pending')) }}
                        </span>
                    </div>
                    <p class="mt-2 mb-1">{{ $review->comments ?? 'No comments yet' }}</p>
                    <small class="text-muted">{{ $review->updated_at->format('M d, Y') }}</small>
                </div>
                @empty
                <p class="text-muted">No reviews submitted yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><strong>Paper Status</strong></div>
            <div class="card-body">
                <p><strong>Current Status:</strong> 
                    <span class="badge bg-{{ $paper->status == 'pending' ? 'warning' : ($paper->status == 'published' ? 'success' : 'info') }}">
                        {{ ucfirst(str_replace('_', ' ', $paper->status)) }}
                    </span>
                </p>
                <p><strong>Submitted:</strong> {{ $paper->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Update Status</strong></div>
            <div class="card-body">
                <form action="{{ route('editor.papers.update', $paper) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $paper->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_review" {{ $paper->status == 'in_review' ? 'selected' : '' }}>In Review</option>
                            <option value="correction_needed" {{ $paper->status == 'correction_needed' ? 'selected' : '' }}>Correction Needed</option>
                            <option value="approved" {{ $paper->status == 'approved' ? 'selected' : '' }}>Review Done - Approved</option>
                            <option value="rejected" {{ $paper->status == 'rejected' ? 'selected' : '' }}>Review Done - Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Paper</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection