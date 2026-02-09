@extends('layouts.admin')
@section('title', 'Posts')
@section('page-title', 'Manage Blog Posts')
@section('page-actions')
<a href="{{ route('admin.posts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Post</a>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Title</th><th>Category</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ Str::limit($post->title, 40) }}</td>
                        <td>{{ $post->category->name ?? 'None' }}</td>
                        <td><span class="badge bg-{{ $post->status == 'published' ? 'success' : 'secondary' }}">{{ ucfirst($post->status) }}</span></td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No posts found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $posts->links() }}
    </div>
</div>
@endsection