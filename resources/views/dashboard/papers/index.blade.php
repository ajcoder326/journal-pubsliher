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
                <thead><tr><th>Title</th><th>Status</th><th>Submitted</th></tr></thead>
                <tbody>
                    @forelse($papers as $paper)
                        <tr>
                            <td>
                                @if($paper->status === 'published')
                                    <a href="{{ route('papers.show', $paper) }}">{{ Str::limit($paper->title, 50) }}</a>
                                @else
                                    <a href="{{ route('dashboard.papers.edit', $paper) }}">{{ Str::limit($paper->title, 50) }}</a>
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
                        <tr><td colspan="3" class="text-center">No papers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $papers->links() }}
        </div>
    </div>
</div>
@endsection