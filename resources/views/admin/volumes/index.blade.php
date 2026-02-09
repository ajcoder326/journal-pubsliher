@extends('layouts.admin')

@section('title', 'Volumes')
@section('page-title', 'Manage Volumes')

@section('page-actions')
<a href="{{ route('admin.volumes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Volume</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Year</th>
                        <th>Issue</th>
                        <th>Status</th>
                        <th>Papers</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($volumes as $volume)
                        <tr>
                            <td>{{ $volume->id }}</td>
                            <td>{{ $volume->title }}</td>
                            <td>{{ $volume->year }}</td>
                            <td>{{ $volume->issue_number }}</td>
                            <td><span class="badge bg-{{ $volume->status == 'published' ? 'success' : 'secondary' }}">{{ ucfirst($volume->status) }}</span></td>
                            <td>{{ $volume->papers->count() }}</td>
                            <td>
                                <a href="{{ route('admin.volumes.edit', $volume) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.volumes.destroy', $volume) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No volumes found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $volumes->links() }}
    </div>
</div>
@endsection