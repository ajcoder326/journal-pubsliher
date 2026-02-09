@extends('layouts.admin')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('page-actions')
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="author" {{ old('role', $user->role) == 'author' ? 'selected' : '' }}>Author</option>
                                <option value="reviewer" {{ old('role', $user->role) == 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                                <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                                <option value="editor_in_chief" {{ old('role', $user->role) == 'editor_in_chief' ? 'selected' : '' }}>Editor-in-Chief</option>
                                <option value="editorial_board" {{ old('role', $user->role) == 'editorial_board' ? 'selected' : '' }}>Editorial Board</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Affiliation</label>
                            <input type="text" name="affiliation" class="form-control" value="{{ old('affiliation', $user->affiliation) }}" placeholder="University / Organization">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Account Info</label>
                        <div class="bg-light p-3 rounded">
                            <small><strong>Created:</strong> {{ $user->created_at->format('F d, Y') }} | <strong>Papers:</strong> {{ $user->papers->count() }} | <strong>Reviews:</strong> {{ $user->reviews->count() }}</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update User</button>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i> Delete User</button>
                    </form>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
