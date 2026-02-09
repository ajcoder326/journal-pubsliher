@extends('layouts.app')

@section('title', 'Blog - SIJSEMSS')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="section-title">Latest News & Articles</h2>
            
            @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-newspaper fa-3x text-white"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="mb-2">
                                        @if($post->category)
                                            <span class="badge bg-primary">{{ $post->category->name }}</span>
                                        @endif
                                        <small class="text-muted ms-2">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>No blog posts available yet.
                </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($categories as $category)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">{{ $category->posts_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No categories</li>
                    @endforelse
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Subscribe to Newsletter</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Stay updated with the latest news and publications.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your email address">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection