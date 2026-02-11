@extends('layouts.admin')

@section('title', 'Paper Details')
@section('page-title', 'Paper Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Paper Information</h5>
                <span class="badge bg-{{ $paper->status == 'published' ? 'success' : ($paper->status == 'pending' ? 'warning' : 'secondary') }}">
                    {{ ucfirst(str_replace('_', ' ', $paper->status)) }}
                </span>
            </div>
            <div class="card-body">
                <h4>{{ $paper->title }}</h4>
                <p class="text-muted">By {{ $paper->user->name }} | Submitted on {{ $paper->submitted_at->format('M d, Y') }}</p>
                
                <hr>
                
                <h5>Abstract</h5>
                <p>{{ $paper->abstract }}</p>
                
                <div class="mt-4">
                    <strong>Keywords:</strong> {{ $paper->keywords ?? 'None' }}
                </div>
                @if($paper->doi)
                <div class="mt-3">
                    <strong>DOI:</strong> <a href="https://doi.org/{{ $paper->doi }}" target="_blank">{{ $paper->doi }}</a>
                </div>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('admin.papers.download', $paper) }}" class="btn btn-outline-primary">
                        <i class="fas fa-download"></i> Download Manuscript
                    </a>
                    @if($paper->final_document_path)
                        <a href="{{ asset('storage/' . $paper->final_document_path) }}" class="btn btn-outline-success ms-2" target="_blank">
                            <i class="fas fa-file-alt"></i> Final Manuscript
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Reviews</h5>
            </div>
            <div class="card-body">
                @forelse($paper->reviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="badge bg-info">{{ ucfirst($review->recommendation) }}</span>
                        </div>
                        <p class="mt-2">{{ $review->comments }}</p>
                        @if($review->attachment_path)
                            <a href="{{ Storage::url($review->attachment_path) }}" class="btn btn-sm btn-link">View Attachment</a>
                        @endif
                        <small class="text-muted">{{ $review->created_at->format('M d, Y H:i') }}</small>
                    </div>
                @empty
                    <p class="text-center text-muted">No reviews submitted yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Assign Reviewer</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.papers.assign-reviewer', $paper) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="reviewer_id" class="form-label">Select Reviewer</label>
                        <select name="reviewer_id" id="reviewer_id" class="form-select" required>
                            <option value="">Choose...</option>
                            @foreach($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}">{{ $reviewer->name }} ({{ $reviewer->papers->count() }} papers)</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Assign Reviewer</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Assigned Reviewers</h5>
            </div>
            <div class="list-group list-group-flush">
                @forelse($paper->assignedReviewers as $assignment)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div>{{ $assignment->user->name }}</div>
                            <small class="text-muted">Status: {{ ucfirst($assignment->status) }}</small>
                        </div>
                    </div>
                @empty
                    <div class="list-group-item text-center text-muted">No reviewers assigned.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
