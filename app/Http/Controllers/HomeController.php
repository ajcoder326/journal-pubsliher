<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Post;
use App\Models\Volume;

class HomeController extends Controller
{
    public function index()
    {
        $latestVolume = Volume::where('status', 'published')->latest()->first();
        $latestPapers = Paper::where('status', 'published')->latest()->take(5)->get();
        $latestPosts = Post::where('status', 'published')->latest()->take(3)->get();
        return view('home', compact('latestVolume', 'latestPapers', 'latestPosts'));
    }

    public function about() { return view('about'); }
    public function editorialBoard() { 
        $editors = \App\Models\User::whereIn('role', ['editor_in_chief', 'editorial_board'])->get();
        return view('editorial-board', compact('editors')); 
    }
    public function callForPapers() { return view('call-for-papers'); }
    public function authorGuidelines() { return view('author-guidelines'); }
    public function researchAreas() { return view('research-areas'); }
    public function submissionWorkflow() { return view('submission-workflow'); }
    public function apc() { return view('apc'); }
}