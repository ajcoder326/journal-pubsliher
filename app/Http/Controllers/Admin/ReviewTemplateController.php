<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewTemplate;
use Illuminate\Http\Request;

class ReviewTemplateController extends Controller
{
    public function index()
    {
        $templates = ReviewTemplate::latest()->paginate(10);
        return view('admin.review-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.review-templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        ReviewTemplate::create($request->all());

        return redirect()->route('admin.review-templates.index')
            ->with('success', 'Review Template created successfully.');
    }

    public function show(ReviewTemplate $reviewTemplate)
    {
        return view('admin.review-templates.show', compact('reviewTemplate'));
    }

    public function edit(ReviewTemplate $reviewTemplate)
    {
        return view('admin.review-templates.edit', compact('reviewTemplate'));
    }

    public function update(Request $request, ReviewTemplate $reviewTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $reviewTemplate->update($request->all());

        return redirect()->route('admin.review-templates.index')
            ->with('success', 'Review Template updated successfully.');
    }

    public function destroy(ReviewTemplate $reviewTemplate)
    {
        $reviewTemplate->delete();

        return redirect()->route('admin.review-templates.index')
            ->with('success', 'Review Template deleted successfully.');
    }
}
