<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\Volume;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function index()
    {
        $papers = Paper::with(['user', 'volume'])->latest()->paginate(15);
        return view('editor.papers.index', compact('papers'));
    }

    public function show(Paper $paper)
    {
        $paper->load(['reviews.user']);
        $reviewTemplates = \App\Models\ReviewTemplate::all();
        return view('editor.papers.show', compact('paper', 'reviewTemplates'));
    }

    public function update(Request $request, Paper $paper)
    {
        $allowedStatuses = ['pending', 'in_review', 'correction_needed', 'approved', 'rejected'];
        $request->validate([
            'status' => 'required|in:' . implode(',', $allowedStatuses),
            'editor_feedback' => 'nullable|string',
        ]);

        $paper->update([
            'status' => $request->status,
            'editor_feedback' => $request->editor_feedback,
        ]);

        return redirect()->route('editor.papers.show', $paper)->with('success', 'Paper status updated successfully.');
    }
}