@extends('layouts.admin')
@section('title', 'Papers')
@section('page-title', 'Manage Papers')
@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.papers.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Title, author, email, phone...">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>In Review</option>
                    <option value="correction_needed" {{ request('status') == 'correction_needed' ? 'selected' : '' }}>Correction Needed</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">From</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">To</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
                <button type="submit" name="export" value="1" class="btn btn-outline-success w-100"><i class="fas fa-file-export me-1"></i>Export</button>
            </div>
        </form>
    </div>
</div>

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
                            <form action="{{ route('admin.papers.destroy', $paper) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this paper?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
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