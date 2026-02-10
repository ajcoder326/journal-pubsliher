@extends('layouts.admin')
@section('title', 'Create Menu Item')
@section('page-title', 'Create Menu Item')

@section('content')
<div class="row">
    <div class="col-md-8">
        <form method="POST" action="{{ route('admin.menus.store') }}">
            @csrf
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-link me-2"></i>Menu Item Details</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Menu item text">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Location <span class="text-danger">*</span></label>
                            <select name="location" class="form-select @error('location') is-invalid @enderror" required>
                                <option value="header" {{ old('location') === 'header' ? 'selected' : '' }}>Header (Top Nav)</option>
                                <option value="footer" {{ old('location') === 'footer' ? 'selected' : '' }}>Footer</option>
                            </select>
                            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">URL</label>
                            <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" placeholder="/about or https://example.com">
                            @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Direct URL path. Use this OR Route Name below.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Route Name</label>
                            <input type="text" name="route_name" class="form-control @error('route_name') is-invalid @enderror" value="{{ old('route_name') }}" placeholder="e.g. about, contact, volumes.index">
                            @error('route_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Laravel route name. Takes priority over URL if both set.</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Parent Menu</label>
                            <select name="parent_id" class="form-select">
                                <option value="">— None (Top Level) —</option>
                                @foreach($parentMenus as $pm)
                                    <option value="{{ $pm->id }}" {{ old('parent_id') == $pm->id ? 'selected' : '' }}>{{ $pm->title }} ({{ $pm->location }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select parent for dropdown/submenu.</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Icon (FontAwesome)</label>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="fas fa-home">
                            <small class="text-muted">e.g. fas fa-book, fas fa-envelope</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Open In</label>
                            <select name="target" class="form-select">
                                <option value="_self" {{ old('target') === '_self' ? 'selected' : '' }}>Same Window</option>
                                <option value="_blank" {{ old('target') === '_blank' ? 'selected' : '' }}>New Tab</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active (visible on site)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create Menu Item</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Help</h6></div>
            <div class="card-body small">
                <p><strong>URL vs Route Name:</strong></p>
                <ul>
                    <li><strong>URL:</strong> Use for external links or simple paths like <code>/about</code></li>
                    <li><strong>Route Name:</strong> Use Laravel route names like <code>about</code>, <code>contact</code>, <code>volumes.index</code> for internal pages</li>
                </ul>
                <p><strong>Dropdown Menus:</strong> Set a parent menu to create dropdown items. Only header menus support dropdowns.</p>
                <p><strong>Common Route Names:</strong></p>
                <ul class="mb-0">
                    <li><code>home</code> – Homepage</li>
                    <li><code>about</code> – About page</li>
                    <li><code>editorial-board</code> – Editorial Team</li>
                    <li><code>call-for-papers</code> – Call for Papers</li>
                    <li><code>author-guidelines</code> – Guidelines</li>
                    <li><code>volumes.index</code> – Archives</li>
                    <li><code>contact</code> – Contact</li>
                    <li><code>blog.index</code> – Blog</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
