@extends('layouts.admin')
@section('title', 'Messages')
@section('page-title', 'Contact Messages')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($messages as $message)
                    <tr class="{{ !$message->is_read ? 'table-warning' : '' }}">
                        <td>{{ $message->id }}</td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ Str::limit($message->subject, 30) }}</td>
                        <td><span class="badge bg-{{ $message->is_read ? 'success' : 'warning' }}">{{ $message->is_read ? 'Read' : 'New' }}</span></td>
                        <td>{{ $message->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No messages found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $messages->links() }}
    </div>
</div>
@endsection