@extends('layouts.app')
@section('title', 'Submit Paper')
@section('content')
<div class="container py-5">
    <h2>Submit New Paper</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.papers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Paper Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Authors *</label>
                    <input type="text" name="authors" class="form-control @error('authors') is-invalid @enderror" value="{{ old('authors') }}" placeholder="John Doe, Jane Smith" required>
                    @error('authors')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Abstract *</label>
                    <textarea name="abstract" class="form-control @error('abstract') is-invalid @enderror" rows="6" required>{{ old('abstract') }}</textarea>
                    @error('abstract')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Keywords</label>
                    <input type="text" name="keywords" class="form-control" value="{{ old('keywords') }}" placeholder="machine learning, AI, healthcare">
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload Document (PDF, DOC, DOCX) *</label>
                    <input type="file" name="document" class="form-control @error('document') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
                    @error('document')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit Paper</button>
                <a href="{{ route('dashboard.papers.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection