@extends('layouts.admin')
@section('title', 'Pages')
@section('page-title', 'Manage Pages')
@section('page-actions')
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Page</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($pages->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                    <tr>
                        <td>
                            <strong>{{ $page->title }}</strong>
                            @if($page->meta_title)
                                <br><small class="text-muted">SEO: {{ Str::limit($page->meta_title, 40) }}</small>
                            @endif
                        </td>
                        <td><code>/page/{{ $page->slug }}</code></td>
                        <td>
                            @if($page->is_published)
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Published</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-eye-slash me-1"></i>Draft</span>
                            @endif
                        </td>
                        <td>{{ $page->updated_at->diffForHumans() }}</td>
                        <td>
                            <a href="/page/{{ $page->slug }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Preview"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="d-inline" onsubmit="return confirm('Delete this page?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $pages->links() }}</div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
            <h5>No Pages Yet</h5>
            <p class="text-muted">Create your first custom page to display on the website.</p>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Create Page</a>
        </div>
        @endif
    </div>
</div>
@endsection
