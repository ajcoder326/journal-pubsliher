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

            <!-- Downloads & Quick Actions -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-download me-2"></i>Downloads & Quick Actions</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="/downloads/copyright-form.pdf" class="btn btn-outline-primary w-100" target="_blank">
                                <i class="fas fa-file-contract d-block mb-1" style="font-size:1.5rem;"></i>
                                Copyright Form
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/downloads/paper-format.docx" class="btn btn-outline-primary w-100" target="_blank">
                                <i class="fas fa-file-word d-block mb-1" style="font-size:1.5rem;"></i>
                                Paper Format
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('dashboard.papers.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-certificate d-block mb-1" style="font-size:1.5rem;"></i>
                                Get Certificate
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('apc') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-credit-card d-block mb-1" style="font-size:1.5rem;"></i>
                                Payment Options
                            </a>
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
                            <tr><th>Title</th><th>Status</th><th>Submitted</th></tr>
                        </thead>
                        <tbody>
                            @forelse(auth()->user()->papers->take(5) as $paper)
                                <tr>
                                    <td>
                                        @if($paper->status === 'published')
                                            <a href="{{ route('papers.show', $paper) }}">{{ Str::limit($paper->title, 40) }}</a>
                                        @else
                                            <a href="{{ route('dashboard.papers.edit', $paper) }}">{{ Str::limit($paper->title, 40) }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $paper->status == 'published' ? 'success' : ($paper->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($paper->status) }}</span>
                                        @if($paper->status === 'published')
                                            <div class="small mt-1"><a href="{{ route('papers.show', $paper) }}">View Published Paper</a></div>
                                            <div class="small"><a href="{{ route('dashboard.papers.certificate', $paper) }}">Download Certificate</a></div>
                                        @endif
                                    </td>
                                    <td>{{ $paper->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No papers submitted yet. <a href="{{ route('dashboard.papers.create') }}">Submit your first paper!</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection