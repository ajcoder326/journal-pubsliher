@extends('layouts.admin')

@section('title', 'Email Templates')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Email Templates</h1>
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

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Email Templates</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Template Name</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templates as $template)
                            <tr>
                                <td>
                                    <strong>{{ ucwords(str_replace('_', ' ', $template->name)) }}</strong>
                                    <br><small class="text-muted">{{ $template->name }}</small>
                                </td>
                                <td>{{ Str::limit($template->subject, 40) }}</td>
                                <td>{{ Str::limit($template->description, 50) }}</td>
                                <td>
                                    <form action="{{ route('admin.email-templates.toggle', $template) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $template->is_active ? 'btn-success' : 'btn-secondary' }}">
                                            <i class="fas fa-{{ $template->is_active ? 'check' : 'times' }}"></i>
                                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.email-templates.edit', $template) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.email-templates.preview', $template) }}" class="btn btn-sm btn-info" title="Preview" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-muted mb-0">No email templates found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">SMTP Configuration</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                SMTP settings are configured in the <code>.env</code> file. Current configuration:
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Mail Driver:</strong></td>
                            <td>{{ config('mail.default') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mail Host:</strong></td>
                            <td>{{ config('mail.mailers.smtp.host') ?: 'Not configured' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mail Port:</strong></td>
                            <td>{{ config('mail.mailers.smtp.port') ?: 'Not configured' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Encryption:</strong></td>
                            <td>{{ config('mail.mailers.smtp.encryption') ?: 'None' }}</td>
                        </tr>
                        <tr>
                            <td><strong>From Address:</strong></td>
                            <td>{{ config('mail.from.address') ?: 'Not configured' }}</td>
                        </tr>
                        <tr>
                            <td><strong>From Name:</strong></td>
                            <td>{{ config('mail.from.name') ?: 'Not configured' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded">
                        <h6>Example .env Configuration:</h6>
                        <pre class="mb-0"><code>MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@dejournal.com
MAIL_FROM_NAME="SHARE IJ"</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
