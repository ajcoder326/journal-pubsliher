@extends('layouts.app')
@section('title', 'My Papers')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Papers</h2>
        <a href="{{ route('dashboard.papers.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Submit New Paper</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead><tr><th>Title</th><th>Status</th><th>Submitted</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($papers as $paper)
                        <tr>
                            <td>{{ Str::limit($paper->title, 50) }}</td>
                            <td><span class="badge bg-{{ $paper->status == 'published' ? 'success' : ($paper->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($paper->status) }}</span></td>
                            <td>{{ $paper->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('dashboard.papers.edit', $paper) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No papers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $papers->links() }}
        </div>
    </div>
</div>
@endsection