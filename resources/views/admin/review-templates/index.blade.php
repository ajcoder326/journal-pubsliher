@extends('layouts.admin')

@section('title', 'Review Templates')
@section('page-title', 'Manage Review Templates')

@section('page-actions')
    <a href="{{ route('admin.review-templates.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Template
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Content Preview</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $template)
                        <tr>
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->name }}</td>
                            <td>{{ Str::limit($template->content, 60) }}</td>
                            <td>{{ $template->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.review-templates.edit', $template) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.review-templates.destroy', $template) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No templates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $templates->links() }}
        </div>
    </div>
@endsection