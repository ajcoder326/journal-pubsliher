<?php

namespace App\Services;

use App\Mail\DynamicTemplateMail;
use App\Models\EmailTemplate;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send email notification using a template
     */
    public static function send(string $templateName, string $toEmail, array $placeholders = []): bool
    {
        try {
            // Check if template exists and is active
            $template = EmailTemplate::where('name', $templateName)
                                     ->where('is_active', true)
                                     ->first();
            
            if (!$template) {
                Log::warning("Email template not found or inactive: {$templateName}");
                return false;
            }

            // Add common placeholders
            $placeholders['dashboard_url'] = $placeholders['dashboard_url'] ?? url('/dashboard');
            $placeholders['login_url'] = $placeholders['login_url'] ?? url('/login');

            Mail::to($toEmail)->send(new DynamicTemplateMail($templateName, $placeholders));
            
            Log::info("Email sent successfully", [
                'template' => $templateName,
                'to' => $toEmail,
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send email", [
                'template' => $templateName,
                'to' => $toEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Notify author when paper is submitted
     */
    public static function notifyPaperSubmitted(Paper $paper): void
    {
        $author = $paper->user;
        
        if (!$author) return;

        self::send('paper_submitted_author', $author->email, [
            'author_name' => $author->name,
            'paper_title' => $paper->title,
            'authors' => $paper->authors,
            'submitted_date' => $paper->created_at->format('F d, Y'),
        ]);

        // Also notify editors
        self::notifyEditorsNewSubmission($paper);
    }

    /**
     * Notify editors about new paper submission
     */
    public static function notifyEditorsNewSubmission(Paper $paper): void
    {
        $editors = User::whereIn('role', ['editor', 'editor_in_chief', 'admin'])->get();
        
        foreach ($editors as $editor) {
            self::send('paper_submitted_editor', $editor->email, [
                'paper_title' => $paper->title,
                'authors' => $paper->authors,
                'submitter_name' => $paper->user->name ?? 'Unknown',
                'submitter_email' => $paper->user->email ?? '',
                'submitted_date' => $paper->created_at->format('F d, Y'),
                'abstract' => $paper->abstract,
                'review_url' => url('/admin/papers/' . $paper->id),
            ]);
        }
    }

    /**
     * Notify author when paper status changes
     */
    public static function notifyPaperStatusChanged(Paper $paper, string $oldStatus, string $newStatus): void
    {
        $author = $paper->user;
        
        if (!$author) return;

        self::send('paper_status_changed', $author->email, [
            'author_name' => $author->name,
            'paper_title' => $paper->title,
            'old_status' => ucfirst(str_replace('_', ' ', $oldStatus)),
            'new_status' => ucfirst(str_replace('_', ' ', $newStatus)),
        ]);
    }

    /**
     * Notify reviewer when assigned to a paper
     */
    public static function notifyReviewerAssigned(Paper $paper, User $reviewer): void
    {
        self::send('reviewer_assigned', $reviewer->email, [
            'reviewer_name' => $reviewer->name,
            'paper_title' => $paper->title,
            'authors' => $paper->authors,
            'keywords' => $paper->keywords ?? 'Not specified',
            'abstract' => $paper->abstract,
            'review_url' => url('/editor/papers/' . $paper->id . '/review'),
        ]);
    }

    /**
     * Notify editors when a review is submitted
     */
    public static function notifyReviewSubmitted(Paper $paper, User $reviewer): void
    {
        $editors = User::whereIn('role', ['editor', 'editor_in_chief', 'admin'])->get();

        foreach ($editors as $editor) {
            self::send('review_submitted', $editor->email, [
                'editor_name' => $editor->name,
                'reviewer_name' => $reviewer->name,
                'paper_title' => $paper->title,
                'review_url' => url('/admin/papers/' . $paper->id),
            ]);
        }
    }
}