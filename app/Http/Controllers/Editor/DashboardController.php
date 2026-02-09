<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingPapers = Paper::where('status', 'pending')->count();
        $underReview = Paper::where('status', 'in_review')->count();
        $completedReviews = Review::whereNotNull('recommendation')->count();
        $papers = Paper::whereIn('status', ['pending', 'in_review', 'correction_needed'])
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('editor.dashboard', compact('pendingPapers', 'underReview', 'completedReviews', 'papers'));
    }
}