@extends('layouts.admin')
@section('title', 'Edit Page')
@section('page-title')
    Edit Page: {{ $page->title }}
@endsection

@section('content')
<form method="POST" action="{{ route('admin.pages.update', $page) }}">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text">/page/</span>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $page->slug) }}">
                        </div>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Content</label>
                        <textarea name="content" id="pageContent" class="form-control" rows="15">{{ old('content', $page->content) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Publish</h6></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="isPublished" {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isPublished">Published</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $page->sort_order) }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2"><i class="fas fa-save me-1"></i> Update Page</button>
                    <a href="/page/{{ $page->slug }}" class="btn btn-outline-secondary w-100" target="_blank"><i class="fas fa-eye me-1"></i> Preview</a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">SEO</h6></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete this page permanently?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-1"></i> Delete Page</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/suneditor@2.47.5/dist/css/suneditor.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/suneditor@2.47.5/dist/suneditor.min.js"></script>
<script>
    SunEditor.create(document.getElementById('pageContent'), {
        height: 350,
        buttonList: [
            ['undo', 'redo'],
            ['formatBlock', 'font', 'fontSize'],
            ['bold', 'underline', 'italic', 'strike', 'removeFormat'],
            ['fontColor', 'hiliteColor'],
            ['align', 'list', 'indent', 'outdent'],
            ['table', 'link', 'image', 'horizontalRule'],
            ['codeView', 'fullScreen']
        ]
    });
</script>
@endsection
