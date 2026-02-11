@extends('layouts.app')
@section('title', 'Edit Paper')
@section('content')
<div class="container py-5">
    <h2>Edit Paper</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.papers.update', $paper) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Paper Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $paper->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Authors *</label>
                    <input type="text" name="authors" class="form-control" value="{{ old('authors', $paper->authors) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Abstract *</label>
                    <textarea name="abstract" class="form-control" rows="6" required>{{ old('abstract', $paper->abstract) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keywords</label>
                    <input type="text" name="keywords" class="form-control" value="{{ old('keywords', $paper->keywords) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($paper->status) }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Final Manuscript (Required Format)</label>
                    <input type="file" name="final_document" class="form-control" accept=".pdf,.doc,.docx">
                    @if($paper->final_document_path)
                        <div class="small mt-2">
                            Current file: <a href="{{ asset('storage/' . $paper->final_document_path) }}" target="_blank">Download</a>
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update Paper</button>
                <a href="{{ route('dashboard.papers.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>

    @if($paper->reviews && $paper->reviews->count() > 0)
        <div class="card mt-4">
            <div class="card-header"><strong>Reviewer Comments</strong></div>
            <div class="card-body">
                @foreach($paper->reviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name ?? 'Reviewer' }}</strong>
                            <span class="badge bg-{{ $review->recommendation == 'accept' ? 'success' : ($review->recommendation == 'reject' ? 'danger' : 'warning') }}">
                                {{ ucfirst(str_replace('_', ' ', $review->recommendation ?? 'pending')) }}
                            </span>
                        </div>
                        <p class="mt-2 mb-1">{{ $review->comments }}</p>
                        <small class="text-muted">{{ $review->updated_at->format('M d, Y') }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection