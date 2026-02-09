<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Volume;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaperController extends Controller
{
    /**
     * Display a published paper (public view)
     */
    public function show(Paper $paper)
    {
        // Only show published papers to the public
        if ($paper->status !== 'published') {
            abort(404);
        }

        return view('papers.show', compact('paper'));
    }

    /**
     * Download a paper document
     */
    public function download(Paper $paper)
    {
        // Only allow download of published papers
        if ($paper->status !== 'published') {
            abort(404);
        }

        if (!$paper->document_path || !Storage::disk('public')->exists($paper->document_path)) {
            abort(404, 'Document not found');
        }

        return Storage::disk('public')->download($paper->document_path, $paper->title . '.pdf');
    }

    public function index()
    {
        $papers = auth()->user()->papers()->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.papers.index', compact('papers'));
    }

    public function create()
    {
        return view('dashboard.papers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:500',
            'abstract' => 'required',
            'authors' => 'required',
            'keywords' => 'nullable',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('document')->store('papers', 'public');

        $paper = auth()->user()->papers()->create([
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'authors' => $validated['authors'],
            'keywords' => $validated['keywords'] ?? null,
            'document_path' => $path,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Send email notifications
        NotificationService::notifyPaperSubmitted($paper);

        return redirect()->route('dashboard.papers.index')->with('success', 'Paper submitted successfully! A confirmation email has been sent.');
    }

    public function edit(Paper $paper)
    {
        abort_if($paper->user_id !== auth()->id(), 403);
        return view('dashboard.papers.edit', compact('paper'));
    }

    public function update(Request $request, Paper $paper)
    {
        abort_if($paper->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title' => 'required|max:500',
            'abstract' => 'required',
            'authors' => 'required',
            'keywords' => 'nullable',
        ]);

        $paper->update($validated);
        return redirect()->route('dashboard.papers.index')->with('success', 'Paper updated!');
    }

    public function destroy(Paper $paper)
    {
        abort_if($paper->user_id !== auth()->id(), 403);
        $paper->delete();
        return redirect()->route('dashboard.papers.index')->with('success', 'Paper deleted!');
    }
}