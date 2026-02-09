@extends('layouts.app')
@section('title', 'My Reviews')
@section('content')
<div class="container py-5">
    <h2>My Reviews</h2>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    @if(isset($assignments) && $assignments->count() > 0)
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Pending Review Assignments</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Paper Title</th>
                        <th>Author</th>
                        <th>Assigned</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->paper->title ?? 'N/A' }}</td>
                        <td>{{ $assignment->paper->user->name ?? 'N/A' }}</td>
                        <td>{{ $assignment->created_at->format('M d, Y') }}</td>
                        <td><span class="badge bg-warning text-dark">{{ ucfirst($assignment->status) }}</span></td>
                        <td><a href="{{ route('dashboard.reviews.create', $assignment->paper) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i> Write Review</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-check-circle"></i> Submitted Reviews</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Paper Title</th>
                        <th>Recommendation</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->paper->title ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $review->recommendation == 'accept' ? 'success' : ($review->recommendation == 'reject' ? 'danger' : 'warning') }}">
                                {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                            </span>
                        </td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td><a href="{{ route('dashboard.reviews.show', $review) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No reviews submitted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection