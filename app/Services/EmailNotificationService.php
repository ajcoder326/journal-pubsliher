<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailNotificationService
{
    /**
     * Send email using a template from the database
     */
    public static function sendEmail(string $templateName, string $toEmail, array $data = []): bool
    {
        $template = EmailTemplate::where('name', $templateName)->where('is_active', true)->first();
        
        if (!$template) {
            Log::warning("Email template '{$templateName}' not found or inactive.");
            return false;
        }

        try {
            $subject = self::replacePlaceholders($template->subject, $data);
            $body = self::replacePlaceholders($template->body, $data);

            Mail::html($body, function($message) use ($toEmail, $subject) {
                $message->to($toEmail)->subject($subject);
            });

            Log::info("Email sent: {$templateName} to {$toEmail}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send email: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Replace placeholders in template
     */
    protected static function replacePlaceholders(string $content, array $data): string
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return $content;
    }

    /**
     * Send paper status changed notification to author
     */
    public static function notifyPaperStatusChanged(Paper $paper, string $oldStatus, string $newStatus): bool
    {
        $author = $paper->user;
        if (!$author) return false;

        return self::sendEmail('paper_status_changed', $author->email, [
            'author_name' => $author->name,
            'paper_title' => $paper->title,
            'old_status' => ucfirst(str_replace('_', ' ', $oldStatus)),
            'new_status' => ucfirst(str_replace('_', ' ', $newStatus)),
            'dashboard_url' => route('dashboard.index'),
        ]);
    }

    /**
     * Send confirmation to author after paper submission
     */
    public static function notifyPaperSubmittedToAuthor(Paper $paper): bool
    {
        $author = $paper->user;
        if (!$author) return false;

        return self::sendEmail('paper_submitted_author', $author->email, [
            'author_name' => $author->name,
            'paper_title' => $paper->title,
            'authors' => $paper->authors,
            'submitted_date' => $paper->created_at->format('F d, Y'),
            'dashboard_url' => route('dashboard.index'),
        ]);
    }

    /**
     * Send notification to editors when new paper is submitted
     */
    public static function notifyPaperSubmittedToEditors(Paper $paper): void
    {
        $editors = User::whereIn('role', ['admin', 'editor', 'editor_in_chief'])->get();
        $submitter = $paper->user;

        foreach ($editors as $editor) {
            self::sendEmail('paper_submitted_editor', $editor->email, [
                'paper_title' => $paper->title,
                'authors' => $paper->authors,
                'submitter_name' => $submitter ? $submitter->name : 'Unknown',
                'submitter_email' => $submitter ? $submitter->email : 'N/A',
                'submitted_date' => $paper->created_at->format('F d, Y'),
                'abstract' => $paper->abstract,
                'review_url' => route('admin.papers.show', $paper),
            ]);
        }
    }

    /**
     * Send notification to reviewer when assigned to paper
     */
    public static function notifyReviewerAssigned(Paper $paper, User $reviewer): bool
    {
        return self::sendEmail('reviewer_assigned', $reviewer->email, [
            'reviewer_name' => $reviewer->name,
            'paper_title' => $paper->title,
            'authors' => $paper->authors,
            'keywords' => $paper->keywords,
            'abstract' => $paper->abstract,
            'review_url' => route('dashboard.reviews.index'),
        ]);
    }

    /**
     * Send notification when review is submitted
     */
    public static function notifyReviewSubmitted(Paper $paper, User $reviewer, string $recommendation): void
    {
        // Notify editors
        $editors = User::whereIn('role', ['admin', 'editor', 'editor_in_chief'])->get();

        foreach ($editors as $editor) {
            self::sendEmail('review_submitted', $editor->email, [
                'paper_title' => $paper->title,
                'reviewer_name' => $reviewer->name,
                'recommendation' => ucfirst(str_replace('_', ' ', $recommendation)),
                'submitted_date' => now()->format('F d, Y'),
                'review_url' => route('admin.papers.show', $paper),
            ]);
        }
    }

    /**
     * Send welcome email to new user
     */
    public static function sendWelcomeEmail(User $user): bool
    {
        return self::sendEmail('welcome_user', $user->email, [
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => ucfirst($user->role),
            'login_url' => route('login'),
        ]);
    }
}