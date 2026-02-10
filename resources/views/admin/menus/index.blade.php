@extends('layouts.admin')
@section('title', 'Menus')
@section('page-title', 'Manage Menus')
@section('page-actions')
    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Menu Item</a>
@endsection

@section('content')
<div class="row">
    {{-- Header Menus --}}
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-window-maximize me-2"></i>Header Menu</h5>
                <span class="badge bg-primary">{{ $headerMenus->count() }} items</span>
            </div>
            <div class="card-body p-0">
                @if($headerMenus->count())
                <div class="list-group list-group-flush" id="headerMenuList">
                    @foreach($headerMenus as $menu)
                    <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $menu->id }}">
                        <div>
                            <i class="fas fa-grip-vertical text-muted me-2 drag-handle" style="cursor:grab;"></i>
                            @if($menu->icon)<i class="{{ $menu->icon }} me-1 text-primary"></i>@endif
                            <strong>{{ $menu->title }}</strong>
                            <small class="text-muted ms-2">{{ $menu->url ?: $menu->route_name }}</small>
                            @if(!$menu->is_active)<span class="badge bg-secondary ms-1">Hidden</span>@endif
                            @if($menu->target === '_blank')<i class="fas fa-external-link-alt ms-1 text-muted small"></i>@endif
                        </div>
                        <div>
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" class="d-inline" onsubmit="return confirm('Delete this menu item and all its children?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    @if($menu->children->count())
                        @foreach($menu->children as $child)
                        <div class="list-group-item d-flex justify-content-between align-items-center ps-5" data-id="{{ $child->id }}">
                            <div>
                                <i class="fas fa-level-up-alt fa-rotate-90 text-muted me-2"></i>
                                @if($child->icon)<i class="{{ $child->icon }} me-1 text-muted"></i>@endif
                                {{ $child->title }}
                                <small class="text-muted ms-2">{{ $child->url ?: $child->route_name }}</small>
                                @if(!$child->is_active)<span class="badge bg-secondary ms-1">Hidden</span>@endif
                            </div>
                            <div>
                                <a href="{{ route('admin.menus.edit', $child) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('admin.menus.destroy', $child) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    @endforeach
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-bars fa-2x mb-2"></i>
                    <p class="mb-0">No header menu items yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Footer Menus --}}
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-shoe-prints me-2"></i>Footer Menu</h5>
                <span class="badge bg-primary">{{ $footerMenus->count() }} items</span>
            </div>
            <div class="card-body p-0">
                @if($footerMenus->count())
                <div class="list-group list-group-flush" id="footerMenuList">
                    @foreach($footerMenus as $menu)
                    <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $menu->id }}">
                        <div>
                            <i class="fas fa-grip-vertical text-muted me-2 drag-handle" style="cursor:grab;"></i>
                            @if($menu->icon)<i class="{{ $menu->icon }} me-1 text-primary"></i>@endif
                            <strong>{{ $menu->title }}</strong>
                            <small class="text-muted ms-2">{{ $menu->url ?: $menu->route_name }}</small>
                            @if(!$menu->is_active)<span class="badge bg-secondary ms-1">Hidden</span>@endif
                        </div>
                        <div>
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    @if($menu->children->count())
                        @foreach($menu->children as $child)
                        <div class="list-group-item d-flex justify-content-between align-items-center ps-5" data-id="{{ $child->id }}">
                            <div>
                                <i class="fas fa-level-up-alt fa-rotate-90 text-muted me-2"></i>
                                @if($child->icon)<i class="{{ $child->icon }} me-1 text-muted"></i>@endif
                                {{ $child->title }}
                                <small class="text-muted ms-2">{{ $child->url ?: $child->route_name }}</small>
                            </div>
                            <div>
                                <a href="{{ route('admin.menus.edit', $child) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('admin.menus.destroy', $child) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    @endforeach
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-bars fa-2x mb-2"></i>
                    <p class="mb-0">No footer menu items yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    <i class="fas fa-info-circle me-1"></i>
    <strong>How menus work:</strong> Header menus appear in the top navbar (supports dropdowns via parent-child). Footer menus appear in the footer section. 
    Items with a <strong>Route Name</strong> will use Laravel routes; items with a <strong>URL</strong> will link directly.
</div>
@endsection
