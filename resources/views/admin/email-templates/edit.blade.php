@extends('layouts.admin')

@section('title', 'Edit Email Template')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Email Template</h1>
        <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Templates
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ ucwords(str_replace('_', ' ', $emailTemplate->name)) }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.email-templates.update', $emailTemplate) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                id="subject" name="subject" value="{{ old('subject', $emailTemplate->subject) }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">You can use placeholders like {paper_title}</small>
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Email Body (HTML) <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('body') is-invalid @enderror" 
                                id="body" name="body" rows="15" required>{{ old('body', $emailTemplate->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" value="{{ old('description', $emailTemplate->description) }}">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                    {{ old('is_active', $emailTemplate->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Template Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.email-templates.preview', $emailTemplate) }}" class="btn btn-info" target="_blank">
                                <i class="fas fa-eye me-1"></i> Preview
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Test Email Section -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Send Test Email</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.email-templates.test', $emailTemplate) }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-8">
                            <input type="email" class="form-control" name="test_email" placeholder="Enter test email address" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-paper-plane me-1"></i> Send Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Available Placeholders</h6>
                </div>
                <div class="card-body">
                    @if(count($placeholders) > 0)
                        <p class="text-muted small">Click to copy:</p>
                        @foreach($placeholders as $placeholder)
                            <span class="badge bg-secondary me-1 mb-2 placeholder-badge" 
                                style="cursor: pointer; font-size: 0.9em;" 
                                onclick="copyToClipboard('{{ $placeholder }}')">
                                {{ $placeholder }}
                            </span>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">No specific placeholders for this template.</p>
                    @endif

                    <hr>
                    <h6 class="small font-weight-bold">Common Placeholders</h6>
                    <p class="text-muted small">These work in any template:</p>
                    <span class="badge bg-info me-1 mb-2" style="cursor: pointer;" onclick="copyToClipboard('{dashboard_url}')">{dashboard_url}</span>
                    <span class="badge bg-info me-1 mb-2" style="cursor: pointer;" onclick="copyToClipboard('{login_url}')">{login_url}</span>
                </div>
            </div>

            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">HTML Tips</h6>
                </div>
                <div class="card-body small">
                    <ul class="mb-0">
                        <li>Use inline CSS styles for best email client compatibility</li>
                        <li>Use <code>&lt;table&gt;</code> for layouts</li>
                        <li>Keep images to a minimum</li>
                        <li>Test in multiple email clients</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Copied: ' + text);
    });
}
</script>
@endsection
