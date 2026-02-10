@extends('layouts.editor')
@section('title', 'Reviewer Dashboard')
@section('content')
<h2 class="mb-4">Reviewer Dashboard</h2>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-warning bg-opacity-10 text-warning me-3">
                    <i class="fas fa-clock fa-lg"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $pendingPapers }}</h3>
                    <small class="text-muted">Pending Review</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-info bg-opacity-10 text-info me-3">
                    <i class="fas fa-spinner fa-lg"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $underReview }}</h3>
                    <small class="text-muted">Under Review</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-success bg-opacity-10 text-success me-3">
                    <i class="fas fa-check-circle fa-lg"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $completedReviews }}</h3>
                    <small class="text-muted">Completed Reviews</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Papers Awaiting Decision</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($papers as $paper)
                <tr>
                    <td>{{ Str::limit($paper->title, 40) }}</td>
                    <td>{{ $paper->created_at->format('M d, Y') }}</td>
                    <td><span class="badge bg-{{ $paper->status == 'pending' ? 'warning' : ($paper->status == 'in_review' ? 'info' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $paper->status)) }}</span></td>
                    <td><a href="{{ route('editor.papers.show', $paper) }}" class="btn btn-sm btn-outline-primary">Review</a></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">No papers awaiting review</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection