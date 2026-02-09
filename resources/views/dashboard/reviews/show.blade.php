@extends('layouts.app')
@section('title', 'Review Paper')
@section('content')
<div class="container py-5">
    <h2>Review Paper</h2>
    <div class="card mb-4">
        <div class="card-header"><strong>Paper Details</strong></div>
        <div class="card-body">
            <h5>{{ $review->paper->title ?? 'N/A' }}</h5>
            <p><strong>Authors:</strong> {{ $review->paper->authors ?? 'N/A' }}</p>
            <p><strong>Abstract:</strong></p>
            <p>{{ $review->paper->abstract ?? 'N/A' }}</p>
        </div>
    </div>
    @if(!$review->recommendation)
    <div class="card">
        <div class="card-header"><strong>Submit Review</strong></div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.reviews.store', $review->paper) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Recommendation *</label>
                    <select name="recommendation" class="form-select" required>
                        <option value="">Select...</option>
                        <option value="accept">Accept</option>
                        <option value="minor_revision">Minor Revision</option>
                        <option value="major_revision">Major Revision</option>
                        <option value="reject">Reject</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Comments for Authors *</label>
                    <textarea name="comments" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confidential Comments for Editor</label>
                    <textarea name="confidential_comments" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-header"><strong>Your Review</strong></div>
        <div class="card-body">
            <p><strong>Recommendation:</strong> {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}</p>
            <p><strong>Comments:</strong> {{ $review->comments }}</p>
            <p class="text-muted">Submitted on {{ $review->updated_at->format('M d, Y') }}</p>
        </div>
    </div>
    @endif
    <a href="{{ route('dashboard.reviews.index') }}" class="btn btn-secondary mt-3">Back to Reviews</a>
</div>
@endsection