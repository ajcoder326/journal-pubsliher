@extends('layouts.admin')
@section('title', 'Review Details')
@section('page-title', 'Review Details')

@section('page-actions')
<a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Review Comments</h5></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <strong>Reviewer:</strong> {{ $review->user->name ?? 'N/A' }}
                    </div>
                    <div>
                        @if($review->recommendation)
                            <span class="badge bg-{{ $review->recommendation == 'accept' ? 'success' : ($review->recommendation == 'reject' ? 'danger' : 'warning') }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">Pending</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="bg-light p-3 rounded">
                    {!! nl2br(e($review->comments)) !!}
                </div>
                @if($review->attachment_path)
                <div class="mt-3">
                    <a href="{{ Storage::url($review->attachment_path) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                        <i class="fas fa-paperclip"></i> View Attachment
                    </a>
                </div>
                @endif
                <div class="mt-3 text-muted small">
                    Submitted on {{ $review->created_at->format('F d, Y \a\t h:i A') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Paper Info</h5></div>
            <div class="card-body">
                @if($review->paper)
                    <h6>{{ $review->paper->title }}</h6>
                    <p class="text-muted small mb-1"><strong>Authors:</strong> {{ $review->paper->authors }}</p>
                    <p class="text-muted small mb-1"><strong>Submitted by:</strong> {{ $review->paper->user->name ?? 'N/A' }}</p>
                    <p class="text-muted small mb-3"><strong>Status:</strong>
                        <span class="badge bg-{{ $review->paper->status == 'published' ? 'success' : ($review->paper->status == 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $review->paper->status)) }}
                        </span>
                    </p>
                    <a href="{{ route('admin.papers.show', $review->paper) }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-eye"></i> View Paper
                    </a>
                @else
                    <p class="text-muted">Paper has been deleted.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
