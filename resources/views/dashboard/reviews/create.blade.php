@extends('layouts.app')
@section('title', 'Write Review')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Write Review</h2>
        <a href="{{ route('dashboard.reviews.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Reviews
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-alt"></i> Paper Details</h5>
                </div>
                <div class="card-body">
                    <h4>{{ $paper->title }}</h4>
                    <p class="text-muted">
                        <strong>Authors:</strong> {{ $paper->authors }}<br>
                        <strong>Submitted by:</strong> {{ $paper->user->name }}<br>
                        <strong>Submitted on:</strong> {{ $paper->submitted_at->format('M d, Y') }}
                    </p>
                    <hr>
                    <h5>Abstract</h5>
                    <p>{{ $paper->abstract }}</p>

                    @if($paper->keywords)
                    <div class="mt-3">
                        <strong>Keywords:</strong>
                        @foreach(explode(',', $paper->keywords) as $keyword)
                            <span class="badge bg-light text-dark me-1">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                    @endif

                    @if($paper->document_path)
                    <div class="mt-3">
                        <a href="{{ route('admin.papers.download', $paper) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-download"></i> Download Manuscript
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-pen"></i> Submit Your Review</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.reviews.store', $paper) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Recommendation <span class="text-danger">*</span></label>
                            <select name="recommendation" class="form-select" required>
                                <option value="">Select recommendation...</option>
                                <option value="accept" {{ old('recommendation') == 'accept' ? 'selected' : '' }}>Accept</option>
                                <option value="minor_revision" {{ old('recommendation') == 'minor_revision' ? 'selected' : '' }}>Minor Revision</option>
                                <option value="major_revision" {{ old('recommendation') == 'major_revision' ? 'selected' : '' }}>Major Revision</option>
                                <option value="reject" {{ old('recommendation') == 'reject' ? 'selected' : '' }}>Reject</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comments for Authors <span class="text-danger">*</span></label>
                            <textarea name="comments" class="form-control" rows="6" required placeholder="Provide detailed feedback on the paper's strengths, weaknesses, and suggestions for improvement...">{{ old('comments') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confidential Comments for Editor</label>
                            <textarea name="confidential_comments" class="form-control" rows="3" placeholder="Optional notes visible only to the editor...">{{ old('confidential_comments') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-paper-plane"></i> Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
