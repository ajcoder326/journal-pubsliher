<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['paper', 'user'])->latest()->paginate(15);
        return view('editor.reviews.index', compact('reviews'));
    }
}