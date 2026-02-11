<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Paper;
use App\Models\Reviewer;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = auth()->user()->reviews()->with('paper')->orderBy('created_at', 'desc')->get();
        $assignments = auth()->user()->reviewerAssignments()
            ->with('paper.user')
            ->whereIn('status', ['pending', 'accepted'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('dashboard.reviews.index', compact('reviews', 'assignments'));
    }

    public function show(Review $review)
    {
        abort_if($review->user_id !== auth()->id(), 403);
        return view('dashboard.reviews.show', compact('review'));
    }

    public function create(Paper $paper)
    {
        // Verify user is assigned as reviewer for this paper
        $assignment = Reviewer::where('paper_id', $paper->id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'accepted'])
            ->firstOrFail();

        $paper->load('user');
        return view('dashboard.reviews.create', compact('paper', 'assignment'));
    }

    public function store(Request $request, Paper $paper)
    {
        // Verify user is assigned as reviewer
        $assignment = Reviewer::where('paper_id', $paper->id)
            ->where('user_id', auth()->id())
            ->first();

        abort_if(!$assignment, 403, 'You are not assigned as a reviewer for this paper.');

        $validated = $request->validate([
            'comment_preset' => 'required|in:comment_1,comment_2,comment_3,comment_4,other',
            'comments' => 'required',
            'other_comments' => 'nullable|string',
            'recommendation' => 'required|in:accept,minor_revision,major_revision,reject',
        ]);

        $comments = $validated['comments'];
        if ($validated['comment_preset'] === 'other' && !empty($validated['other_comments'])) {
            $comments = $validated['other_comments'];
        }

        $paper->reviews()->create([
            'user_id' => auth()->id(),
            'comments' => $comments,
            'recommendation' => $validated['recommendation'],
        ]);

        // Update reviewer assignment status
        $assignment->update(['status' => 'completed']);

        // Update paper status based on recommendation
        $statusMap = [
            'accept' => 'approved',
            'minor_revision' => 'correction_needed',
            'major_revision' => 'correction_needed',
            'reject' => 'rejected',
        ];
        if (isset($statusMap[$validated['recommendation']])) {
            $paper->update(['status' => $statusMap[$validated['recommendation']]]);
        }

        // Notify about review submission
        NotificationService::notifyReviewSubmitted($paper, auth()->user(), $validated['recommendation']);

        return redirect()->route('dashboard.reviews.index')->with('success', 'Review submitted successfully!');
    }
}