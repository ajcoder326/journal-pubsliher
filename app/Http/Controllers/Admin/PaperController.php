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
    public function index(Request $request)
    {
        $query = Paper::with(['user', 'volume', 'assignedReviewers.user'])->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('authors', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('affiliation', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->boolean('export')) {
            $papers = $query->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="papers-export.csv"',
            ];

            return response()->streamDownload(function () use ($papers) {
                $output = fopen('php://output', 'w');
                fputcsv($output, [
                    'Sr No',
                    'Paper ID',
                    'Title',
                    'Status',
                    'Author Name',
                    'Author Email',
                    'Mobile No',
                    'Affiliation',
                    'Submitted Date',
                    'Reviewer Names',
                    'Reviewer Emails',
                ]);

                foreach ($papers as $index => $paper) {
                    $reviewerNames = $paper->assignedReviewers
                        ->pluck('user.name')
                        ->filter()
                        ->implode('; ');
                    $reviewerEmails = $paper->assignedReviewers
                        ->pluck('user.email')
                        ->filter()
                        ->implode('; ');

                    fputcsv($output, [
                        $index + 1,
                        $paper->id,
                        $paper->title,
                        $paper->status,
                        $paper->user->name ?? 'N/A',
                        $paper->user->email ?? 'N/A',
                        $paper->user->phone ?? 'N/A',
                        $paper->user->affiliation ?? 'N/A',
                        $paper->created_at?->format('Y-m-d') ?? '',
                        $reviewerNames,
                        $reviewerEmails,
                    ]);
                }

                fclose($output);
            }, 'papers-export.csv', $headers);
        }

        $papers = $query->paginate(15)->withQueryString();
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
            'doi' => 'nullable|string|max:255',
        ]);

        $oldStatus = $paper->status;
        $newStatus = $validated['status'];

        $paper->update($validated);

        if ($oldStatus !== $newStatus) {
            if ($newStatus === 'published') {
                $paper->update(['published_at' => now()]);
            } elseif ($oldStatus === 'published') {
                $paper->update(['published_at' => null]);
            }
        }

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