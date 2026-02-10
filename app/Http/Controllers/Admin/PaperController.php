<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\Reviewer;
use App\Models\User;
use App\Models\Volume;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaperController extends Controller
{
    public function index()
    {
        $papers = Paper::with(['user', 'volume'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.papers.index', compact('papers'));
    }

    public function show(Paper $paper)
    {
        $paper->load(['user', 'volume', 'reviews.user', 'assignedReviewers.user']);
        $reviewers = User::whereIn('role', ['reviewer', 'editor', 'editor_in_chief'])->get();
        return view('admin.papers.show', compact('paper', 'reviewers'));
    }

    public function edit(Paper $paper)
    {
        $volumes = Volume::all();
        return view('admin.papers.edit', compact('paper', 'volumes'));
    }

    public function update(Request $request, Paper $paper)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required|in:pending,in_review,correction_needed,approved,rejected,published',
            'volume_id' => 'nullable|exists:volumes,id',
        ]);

        $oldStatus = $paper->status;
        $newStatus = $validated['status'];

        $paper->update($validated);

        // Send email notification if status changed
        if ($oldStatus !== $newStatus) {
            NotificationService::notifyPaperStatusChanged($paper, $oldStatus, $newStatus);
        }

        return redirect()->route('admin.papers.index')->with('success', 'Paper updated successfully. Author has been notified via email.');
    }

    public function destroy(Paper $paper)
    {
        $paper->delete();
        return redirect()->route('admin.papers.index')->with('success', 'Paper deleted.');
    }

    public function assignReviewer(Request $request, Paper $paper)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);

        $reviewer = User::findOrFail($request->reviewer_id);

        // Create Reviewer record
        Reviewer::firstOrCreate(
            ['paper_id' => $paper->id, 'user_id' => $reviewer->id],
            ['status' => 'pending']
        );

        // Send notification to reviewer
        NotificationService::notifyReviewerAssigned($paper, $reviewer);

        // Update paper status to in_review if it is pending
        if ($paper->status === 'pending') {
            $paper->update(['status' => 'in_review']);
        }

        return redirect()->back()->with('success', "Reviewer {$reviewer->name} has been assigned and notified via email.");
    }

    public function download(Paper $paper)
    {
        if (!$paper->document_path || !Storage::disk('public')->exists($paper->document_path)) {
            abort(404, 'Document not found');
        }

        return Storage::disk('public')->download($paper->document_path, Str::slug($paper->title) . '.pdf');
    }
}