<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'paper_status_changed',
                'subject' => 'Paper Status Update: {paper_title}',
                'body' => '<h2>Dear {author_name},</h2>
<p>Your paper has been updated in SHARE IJ.</p>
<table style="width: 100%; margin: 20px 0;">
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Paper Title:</strong></td><td style="padding: 10px;">{paper_title}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Previous Status:</strong></td><td style="padding: 10px;">{old_status}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>New Status:</strong></td><td style="padding: 10px;"><strong style="color: #198754;">{new_status}</strong></td></tr>
</table>
<p>If your paper has been <strong>approved</strong>, please complete the following steps:</p>
<ol>
    <li>Download and fill the <strong>Copyright Form</strong></li>
    <li>Prepare your final manuscript in the prescribed <strong>Paper Format</strong></li>
    <li>Complete the <strong>Publication Fee Payment</strong></li>
    <li>Submit all documents via your dashboard or email to editor@shareij.org</li>
</ol>
<p>You can view the full details and download forms from your dashboard.</p>
<p><a href="{dashboard_url}" style="display: inline-block; padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;">View Dashboard</a></p>
<p>Best regards,<br>SHARE IJ Editorial Team</p>',
                'description' => 'Sent to authors when their paper status is changed by admin/editor',
                'is_active' => true,
            ],
            [
                'name' => 'paper_submitted_author',
                'subject' => 'Paper Submission Confirmation: {paper_title}',
                'body' => '<h2>Dear {author_name},</h2>
<p>Thank you for submitting your paper to SHARE IJ.</p>
<table style="width: 100%; margin: 20px 0;">
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Paper Title:</strong></td><td style="padding: 10px;">{paper_title}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Authors:</strong></td><td style="padding: 10px;">{authors}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Submitted Date:</strong></td><td style="padding: 10px;">{submitted_date}</td></tr>
</table>
<p><a href="{dashboard_url}" style="display: inline-block; padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;">Track Your Submission</a></p>
<p>Best regards,<br>SHARE IJ Editorial Team</p>',
                'description' => 'Confirmation email sent to author after paper submission',
                'is_active' => true,
            ],
            [
                'name' => 'paper_submitted_editor',
                'subject' => 'New Paper Submission: {paper_title}',
                'body' => '<h2>New Paper Submission</h2>
<p>A new paper has been submitted to SHARE IJ.</p>
<table style="width: 100%; margin: 20px 0;">
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Paper Title:</strong></td><td style="padding: 10px;">{paper_title}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Authors:</strong></td><td style="padding: 10px;">{authors}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Submitter:</strong></td><td style="padding: 10px;">{submitter_name} ({submitter_email})</td></tr>
</table>
<h3>Abstract</h3>
<p style="background: #f8f9fa; padding: 15px; border-radius: 5px;">{abstract}</p>
<p><a href="{review_url}" style="display: inline-block; padding: 10px 20px; background: #198754; color: white; text-decoration: none; border-radius: 5px;">Review Submission</a></p>',
                'description' => 'Notification sent to editors when a new paper is submitted',
                'is_active' => true,
            ],
            [
                'name' => 'reviewer_assigned',
                'subject' => 'Review Request: {paper_title}',
                'body' => '<h2>Dear {reviewer_name},</h2>
<p>You have been assigned to review a paper for SHARE IJ.</p>
<table style="width: 100%; margin: 20px 0;">
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Paper Title:</strong></td><td style="padding: 10px;">{paper_title}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Keywords:</strong></td><td style="padding: 10px;">{keywords}</td></tr>
</table>
<h3>Abstract</h3>
<p style="background: #f8f9fa; padding: 15px; border-radius: 5px;">{abstract}</p>
<p><a href="{review_url}" style="display: inline-block; padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;">Submit Review</a></p>',
                'description' => 'Sent to reviewers when they are assigned to review a paper (blind review - no author name)',
                'is_active' => true,
            ],
            [
                'name' => 'review_submitted',
                'subject' => 'Review Completed: {paper_title}',
                'body' => '<h2>Review Submitted</h2>
<p>A review has been submitted for a paper.</p>
<table style="width: 100%; margin: 20px 0;">
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Paper Title:</strong></td><td style="padding: 10px;">{paper_title}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Reviewer:</strong></td><td style="padding: 10px;">{reviewer_name}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Recommendation:</strong></td><td style="padding: 10px;"><strong>{recommendation}</strong></td></tr>
</table>
<p><a href="{review_url}" style="display: inline-block; padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;">View Full Review</a></p>',
                'description' => 'Sent to editors when a reviewer submits their review',
                'is_active' => true,
            ],
            [
                'name' => 'welcome_user',
                'subject' => 'Welcome to SHARE IJ',
                'body' => '<h2>Welcome to SHARE IJ, {user_name}!</h2>
<p>Your account has been created successfully.</p>
<table style="width: 100%; margin: 20px 0;">
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Email:</strong></td><td style="padding: 10px;">{user_email}</td></tr>
    <tr><td style="padding: 10px; background: #f8f9fa;"><strong>Account Type:</strong></td><td style="padding: 10px;">{user_role}</td></tr>
</table>
<p><a href="{login_url}" style="display: inline-block; padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;">Login to Your Account</a></p>',
                'description' => 'Welcome email sent to new users after registration',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['name' => $template['name']],
                $template
            );
        }
    }
}