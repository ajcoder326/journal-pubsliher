<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::orderBy('name')->get();
        return view('admin.email-templates.index', compact('templates'));
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        $placeholders = EmailTemplate::getPlaceholders($emailTemplate->name);
        return view('admin.email-templates.edit', compact('emailTemplate', 'placeholders'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Email template updated successfully!');
    }

    public function preview(EmailTemplate $emailTemplate)
    {
        // Return the body with sample data for preview
        $sampleData = [
            '{author_name}' => 'John Doe',
            '{paper_title}' => 'Sample Research Paper Title',
            '{old_status}' => 'Under Review',
            '{new_status}' => 'Accepted',
            '{dashboard_url}' => url('/dashboard'),
            '{authors}' => 'John Doe, Jane Smith',
            '{submitted_date}' => now()->format('F d, Y'),
            '{submitter_name}' => 'John Doe',
            '{submitter_email}' => 'john@example.com',
            '{abstract}' => 'This is a sample abstract for the research paper...',
            '{review_url}' => url('/admin/papers/1'),
            '{reviewer_name}' => 'Dr. Smith',
            '{keywords}' => 'AI, Machine Learning, Deep Learning',
            '{recommendation}' => 'Accept with Minor Revisions',
            '{user_name}' => 'John Doe',
            '{user_email}' => 'john@example.com',
            '{user_role}' => 'Author',
            '{login_url}' => url('/login'),
        ];

        $subject = str_replace(array_keys($sampleData), array_values($sampleData), $emailTemplate->subject);
        $body = str_replace(array_keys($sampleData), array_values($sampleData), $emailTemplate->body);

        return view('admin.email-templates.preview', compact('emailTemplate', 'subject', 'body'));
    }

    public function toggleStatus(EmailTemplate $emailTemplate)
    {
        $emailTemplate->update(['is_active' => !$emailTemplate->is_active]);
        
        $status = $emailTemplate->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Email template {$status} successfully!");
    }

    public function testEmail(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            // Get sample data
            $sampleData = [
                '{author_name}' => 'Test User',
                '{paper_title}' => 'Test Paper Title',
                '{old_status}' => 'Submitted',
                '{new_status}' => 'Under Review',
                '{dashboard_url}' => url('/dashboard'),
                '{authors}' => 'Test Author',
                '{submitted_date}' => now()->format('F d, Y'),
                '{submitter_name}' => 'Test User',
                '{submitter_email}' => 'test@example.com',
                '{abstract}' => 'This is a test abstract...',
                '{review_url}' => url('/admin'),
                '{reviewer_name}' => 'Test Reviewer',
                '{keywords}' => 'Test, Keywords',
                '{recommendation}' => 'Accept',
                '{user_name}' => 'Test User',
                '{user_email}' => 'test@example.com',
                '{user_role}' => 'Author',
                '{login_url}' => url('/login'),
            ];

            $subject = str_replace(array_keys($sampleData), array_values($sampleData), $emailTemplate->subject);
            $body = str_replace(array_keys($sampleData), array_values($sampleData), $emailTemplate->body);

            \Mail::html($body, function($message) use ($request, $subject) {
                $message->to($request->test_email)
                    ->subject('[TEST] ' . $subject);
            });

            return back()->with('success', 'Test email sent to ' . $request->test_email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}