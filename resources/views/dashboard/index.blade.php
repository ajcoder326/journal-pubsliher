@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> My Account</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('dashboard.papers.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard.papers.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> My Papers
                    </a>
                    <a href="{{ route('dashboard.reviews.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard.reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check"></i> My Reviews
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text-muted">Manage your paper submissions and reviews from here.</p>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary">{{ auth()->user()->papers->count() }}</h3>
                            <p class="mb-0">My Papers</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success">{{ auth()->user()->papers->where('status', 'published')->count() }}</h3>
                            <p class="mb-0">Published</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-warning">{{ auth()->user()->papers->where('status', 'pending')->count() }}</h3>
                            <p class="mb-0">Pending</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Submissions</h5>
                    <a href="{{ route('dashboard.papers.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Submit New Paper
                    </a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr><th>Title</th><th>Status</th><th>Submitted</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            @forelse(auth()->user()->papers->take(5) as $paper)
                                <tr>
                                    <td>{{ Str::limit($paper->title, 40) }}</td>
                                    <td><span class="badge bg-{{ $paper->status == 'published' ? 'success' : ($paper->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($paper->status) }}</span></td>
                                    <td>{{ $paper->created_at->format('M d, Y') }}</td>
                                    <td><a href="{{ route('dashboard.papers.edit', $paper) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">No papers submitted yet. <a href="{{ route('dashboard.papers.create') }}">Submit your first paper!</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection