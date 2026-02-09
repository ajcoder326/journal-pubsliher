@extends('layouts.app')

@section('title', $post->title . ' - SIJSEMSS')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($post->title, 30) }}</li>
                </ol>
            </nav>

            <article>
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}">
                @endif

                <div class="mb-3">
                    @if($post->category)
                        <span class="badge bg-primary">{{ $post->category->name }}</span>
                    @endif
                    <small class="text-muted ms-2">
                        <i class="fas fa-calendar me-1"></i>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}
                    </small>
                    @if($post->user)
                        <small class="text-muted ms-2">
                            <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                        </small>
                    @endif
                </div>

                <h1 class="h2 mb-4">{{ $post->title }}</h1>

                <div class="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Share:</strong>
                        <a href="#" class="text-primary ms-2"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-info ms-2"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-primary ms-2"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Blog
                    </a>
                </div>
            </article>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Posts</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentPosts as $recentPost)
                        <li class="list-group-item">
                            <a href="{{ route('blog.show', $recentPost->slug) }}">{{ $recentPost->title }}</a>
                            <br><small class="text-muted">{{ $recentPost->published_at ? $recentPost->published_at->format('M d, Y') : $recentPost->created_at->format('M d, Y') }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No other posts</li>
                    @endforelse
                </ul>
            </div>

            <div class="card">
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
        </div>
    </div>
</div>
@endsection