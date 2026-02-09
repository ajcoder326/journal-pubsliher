<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function index()
    {
        $volumes = Volume::where('status', 'published')
            ->orderBy('year', 'desc')
            ->orderBy('issue_number', 'desc')
            ->paginate(12);
        return view('volumes.index', compact('volumes'));
    }

    public function show(Volume $volume)
    {
        $volume->load(['papers' => function ($query) {
            $query->where('status', 'published');
        }]);
        return view('volumes.show', compact('volume'));
    }
}