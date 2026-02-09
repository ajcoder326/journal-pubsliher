@extends('layouts.admin')
@section('title', 'Papers')
@section('page-title', 'Manage Papers')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Volume</th><th>Status</th><th>Submitted</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($papers as $paper)
                    <tr>
                        <td>{{ $paper->id }}</td>
                        <td>{{ Str::limit($paper->title, 30) }}</td>
                        <td>{{ $paper->user->name ?? 'N/A' }}</td>
                        <td>{{ $paper->volume->title ?? 'Unassigned' }}</td>
                        <td><span class="badge bg-{{ $paper->status == 'published' ? 'success' : ($paper->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($paper->status) }}</span></td>
                        <td>{{ $paper->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.papers.show', $paper) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.papers.edit', $paper) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No papers found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $papers->links() }}
    </div>
</div>
@endsection