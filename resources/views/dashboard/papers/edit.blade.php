@extends('layouts.app')
@section('title', 'Edit Paper')
@section('content')
<div class="container py-5">
    <h2>Edit Paper</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.papers.update', $paper) }}">
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
                <button type="submit" class="btn btn-primary">Update Paper</button>
                <a href="{{ route('dashboard.papers.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection