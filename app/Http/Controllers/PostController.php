<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display blog listing
     */
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        
        $categories = PostCategory::withCount(['posts' => function($q) {
            $q->where('status', 'published');
        }])->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    /**
     * Display a single blog post
     */
    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $recentPosts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $categories = PostCategory::withCount(['posts' => function($q) {
            $q->where('status', 'published');
        }])->get();

        return view('blog.show', compact('post', 'recentPosts', 'categories'));
    }
}