@extends('layouts.admin')
@section('title', 'Edit Menu Item')
@section('page-title')
    Edit Menu: {{ $menu->title }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <form method="POST" action="{{ route('admin.menus.update', $menu) }}">
            @csrf @method('PUT')
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-link me-2"></i>Menu Item Details</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $menu->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Location <span class="text-danger">*</span></label>
                            <select name="location" class="form-select" required>
                                <option value="header" {{ old('location', $menu->location) === 'header' ? 'selected' : '' }}>Header (Top Nav)</option>
                                <option value="footer" {{ old('location', $menu->location) === 'footer' ? 'selected' : '' }}>Footer</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">URL</label>
                            <input type="text" name="url" class="form-control" value="{{ old('url', $menu->url) }}" placeholder="/about or https://example.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Route Name</label>
                            <input type="text" name="route_name" class="form-control" value="{{ old('route_name', $menu->route_name) }}" placeholder="e.g. about, contact">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Parent Menu</label>
                            <select name="parent_id" class="form-select">
                                <option value="">— None (Top Level) —</option>
                                @foreach($parentMenus as $pm)
                                    @if($pm->id !== $menu->id)
                                    <option value="{{ $pm->id }}" {{ old('parent_id', $menu->parent_id) == $pm->id ? 'selected' : '' }}>{{ $pm->title }} ({{ $pm->location }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Icon</label>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon', $menu->icon) }}" placeholder="fas fa-home">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Open In</label>
                            <select name="target" class="form-select">
                                <option value="_self" {{ old('target', $menu->target) === '_self' ? 'selected' : '' }}>Same Window</option>
                                <option value="_blank" {{ old('target', $menu->target) === '_blank' ? 'selected' : '' }}>New Tab</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $menu->sort_order) }}">
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Menu Item</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
    <div class="col-md-4">
        @if($menu->children->count())
        <div class="card mb-4">
            <div class="card-header"><h6 class="mb-0"><i class="fas fa-sitemap me-2"></i>Child Items ({{ $menu->children->count() }})</h6></div>
            <div class="list-group list-group-flush">
                @foreach($menu->children as $child)
                <a href="{{ route('admin.menus.edit', $child) }}" class="list-group-item list-group-item-action">
                    @if($child->icon)<i class="{{ $child->icon }} me-1"></i>@endif
                    {{ $child->title }}
                    @if(!$child->is_active)<span class="badge bg-secondary">Hidden</span>@endif
                </a>
                @endforeach
            </div>
        </div>
        @endif
        <div class="card">
            <div class="card-body text-center">
                <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" onsubmit="return confirm('Delete this menu item{{ $menu->children->count() ? ' and its ' . $menu->children->count() . ' child items' : '' }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-1"></i> Delete Menu Item</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
