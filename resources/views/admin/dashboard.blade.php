@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-primary bg-opacity-10 text-primary me-3">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['papers'] }}</h3>
                    <small class="text-muted">Total Papers</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-warning bg-opacity-10 text-warning me-3">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['pending_papers'] }}</h3>
                    <small class="text-muted">Pending Review</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-success bg-opacity-10 text-success me-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['published_papers'] }}</h3>
                    <small class="text-muted">Published</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-info bg-opacity-10 text-info me-3">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['users'] }}</h3>
                    <small class="text-muted">Users</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Paper Submissions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPapers as $paper)
                                <tr>
                                    <td>{{ Str::limit($paper->title, 40) }}</td>
                                    <td>{{ $paper->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $paper->status == 'published' ? 'success' : ($paper->status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($paper->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $paper->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No papers yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Unread Messages ({{ $stats['messages'] }})</h5>
            </div>
            <div class="card-body">
                @forelse($recentMessages as $message)
                    <div class="border-bottom pb-2 mb-2">
                        <strong>{{ $message->name }}</strong>
                        <p class="mb-0 small text-muted">{{ Str::limit($message->message, 50) }}</p>
                    </div>
                @empty
                    <p class="text-muted">No unread messages</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection