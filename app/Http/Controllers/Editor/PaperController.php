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
        return view('editor.papers.show', compact('paper'));
    }

    public function update(Request $request, Paper $paper)
    {
        $allowedStatuses = ['pending', 'in_review', 'correction_needed', 'approved', 'rejected'];
        $request->validate(['status' => 'required|in:' . implode(',', $allowedStatuses)]);

        $paper->update([
            'status' => $request->status,
        ]);

        return redirect()->route('editor.papers.show', $paper)->with('success', 'Paper status updated successfully.');
    }
}