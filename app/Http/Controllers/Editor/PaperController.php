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
        $paper->load(['user', 'reviews.user', 'volume']);
        $volumes = Volume::all();
        return view('editor.papers.show', compact('paper', 'volumes'));
    }

    public function update(Request $request, Paper $paper)
    {
        $paper->update([
            'status' => $request->status,
            'volume_id' => $request->volume_id,
        ]);

        return redirect()->route('editor.papers.show', $paper)->with('success', 'Paper updated successfully.');
    }
}