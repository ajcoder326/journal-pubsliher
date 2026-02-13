@extends('layouts.admin')

@section('title', 'Create Review Template')
@section('page-title', 'Create New Review Template')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.review-templates.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Template Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" rows="6"
                        class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                    <div class="form-text">This content will be pre-filled when an editor selects this template.</div>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Template</button>
                <a href="{{ route('admin.review-templates.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection