<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\User;
use App\Models\Volume;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'papers' => Paper::count(),
            'users' => User::count(),
            'volumes' => Volume::count(),
            'messages' => Message::where('is_read', false)->count(),
            'pending_papers' => Paper::where('status', 'pending')->count(),
            'published_papers' => Paper::where('status', 'published')->count(),
        ];

        $recentPapers = Paper::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentMessages = Message::where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPapers', 'recentMessages'));
    }
}