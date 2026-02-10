@extends('layouts.editor')
@section('title', 'Manage Papers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Papers</h2>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($papers as $paper)
                <tr>
                    <td>{{ Str::limit($paper->title, 35) }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $paper->status == 'pending' ? 'warning' : 
                            ($paper->status == 'under_review' ? 'info' : 
                            ($paper->status == 'accepted' ? 'success' : 
                            ($paper->status == 'published' ? 'primary' : 
                            ($paper->status == 'rejected' ? 'danger' : 'secondary')))) 
                        }}">{{ ucfirst(str_replace('_', ' ', $paper->status)) }}</span>
                    </td>
                    <td>{{ $paper->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('editor.papers.show', $paper) }}" class="btn btn-sm btn-outline-primary">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">No papers found</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($papers->hasPages())
        <div class="mt-3">{{ $papers->links() }}</div>
        @endif
    </div>
</div>
@endsection