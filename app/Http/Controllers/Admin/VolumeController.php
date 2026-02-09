<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function index()
    {
        $volumes = Volume::orderBy('year', 'desc')->orderBy('issue_number', 'desc')->paginate(10);
        return view('admin.volumes.index', compact('volumes'));
    }

    public function create()
    {
        return view('admin.volumes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'year' => 'required|integer|min:1900|max:2100',
            'issue_number' => 'required|integer|min:1',
            'status' => 'required|in:draft,published',
        ]);
        Volume::create($validated);
        return redirect()->route('admin.volumes.index')->with('success', 'Volume created successfully.');
    }

    public function edit(Volume $volume)
    {
        return view('admin.volumes.edit', compact('volume'));
    }

    public function update(Request $request, Volume $volume)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'year' => 'required|integer|min:1900|max:2100',
            'issue_number' => 'required|integer|min:1',
            'status' => 'required|in:draft,published',
        ]);
        $volume->update($validated);
        return redirect()->route('admin.volumes.index')->with('success', 'Volume updated successfully.');
    }

    public function destroy(Volume $volume)
    {
        $volume->delete();
        return redirect()->route('admin.volumes.index')->with('success', 'Volume deleted successfully.');
    }
}