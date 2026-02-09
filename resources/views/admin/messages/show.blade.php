@extends('layouts.admin')
@section('title', 'Message Details')
@section('page-title', 'Message Details')

@section('page-actions')
<a href="{{ route('admin.messages.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $message->subject ?? 'No Subject' }}</h5>
                <span class="badge bg-{{ $message->is_read ? 'success' : 'warning' }}">{{ $message->is_read ? 'Read' : 'New' }}</span>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>From:</strong></div>
                        <div class="col-sm-9">{{ $message->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Email:</strong></div>
                        <div class="col-sm-9"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></div>
                    </div>
                    @if($message->phone)
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Phone:</strong></div>
                        <div class="col-sm-9">{{ $message->phone }}</div>
                    </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Date:</strong></div>
                        <div class="col-sm-9">{{ $message->created_at->format('F d, Y \a\t h:i A') }}</div>
                    </div>
                </div>
                <hr>
                <div class="mt-3">
                    <h6>Message:</h6>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Actions</h6></div>
            <div class="card-body">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-reply"></i> Reply via Email
                </a>
                @if(!$message->is_read)
                <form action="{{ route('admin.messages.read', $message) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-success w-100 mb-2"><i class="fas fa-check"></i> Mark as Read</button>
                </form>
                @endif
                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100"><i class="fas fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
