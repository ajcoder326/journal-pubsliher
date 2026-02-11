@extends('layouts.admin')
@section('title', 'Edit Paper')
@section('page-title', 'Edit Paper')

@section('page-actions')
<a href="{{ route('admin.papers.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.papers.update', $paper) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Paper Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $paper->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">DOI</label>
                        <input type="text" name="doi" class="form-control @error('doi') is-invalid @enderror" value="{{ old('doi', $paper->doi) }}" placeholder="10.xxxx/xxxx">
                        @error('doi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Authors</label>
                        <input type="text" class="form-control" value="{{ $paper->authors }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Abstract</label>
                        <div class="bg-light p-3 rounded">{{ $paper->abstract }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keywords</label>
                        <input type="text" class="form-control" value="{{ $paper->keywords ?? 'None' }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status', $paper->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_review" {{ old('status', $paper->status) == 'in_review' ? 'selected' : '' }}>In Review</option>
                            <option value="correction_needed" {{ old('status', $paper->status) == 'correction_needed' ? 'selected' : '' }}>Correction Needed</option>
                            <option value="approved" {{ old('status', $paper->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $paper->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="published" {{ old('status', $paper->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign to Volume</label>
                        <select name="volume_id" class="form-select">
                            <option value="">-- None --</option>
                            @foreach($volumes as $volume)
                                <option value="{{ $volume->id }}" {{ old('volume_id', $paper->volume_id) == $volume->id ? 'selected' : '' }}>{{ $volume->title }} ({{ $volume->year }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Submitted By</label>
                        <input type="text" class="form-control" value="{{ $paper->user->name ?? 'N/A' }} ({{ $paper->user->email ?? '' }})" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Submitted At</label>
                        <input type="text" class="form-control" value="{{ $paper->submitted_at ? $paper->submitted_at->format('M d, Y') : $paper->created_at->format('M d, Y') }}" disabled>
                    </div>
                    @if($paper->document_path)
                    <a href="{{ route('admin.papers.download', $paper) }}" class="btn btn-outline-primary w-100 mb-3">
                        <i class="fas fa-download"></i> Download Document
                    </a>
                    @endif
                    @if($paper->final_document_path)
                    <a href="{{ asset('storage/' . $paper->final_document_path) }}" class="btn btn-outline-success w-100 mb-3" target="_blank">
                        <i class="fas fa-file-alt"></i> Download Final Manuscript
                    </a>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Paper</button>
            <a href="{{ route('admin.papers.show', $paper) }}" class="btn btn-info"><i class="fas fa-eye"></i> View Details</a>
        </form>
    </div>
</div>
@endsection
