<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\Paper;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Setting;
use App\Models\User;
use App\Models\Volume;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            "name" => "Admin User",
            "email" => "admin@shareij.com",
            "password" => Hash::make("password123"),
            "role" => "admin",
            "affiliation" => "SHARE IJ Administration",
        ]);

        User::create([
            "name" => "Dr. John Smith",
            "email" => "editor@shareij.com",
            "password" => Hash::make("password123"),
            "role" => "editor",
            "affiliation" => "Harvard University",
        ]);

        User::create([
            "name" => "Dr. Sarah Johnson",
            "email" => "sarah@shareij.com",
            "password" => Hash::make("password123"),
            "role" => "reviewer",
            "affiliation" => "MIT",
        ]);

        $author = User::create([
            "name" => "Jane Researcher",
            "email" => "author@shareij.com",
            "password" => Hash::make("password123"),
            "role" => "author",
            "affiliation" => "Cambridge University",
        ]);

        $volume1 = Volume::create([
            "title" => "SHARE IJ Volume 1",
            "description" => "Inaugural issue of SHARE IJ featuring groundbreaking research.",
            "year" => 2024,
            "issue_number" => 1,
            "status" => "published",
            "published_at" => now()->subMonths(6),
        ]);

        $volume2 = Volume::create([
            "title" => "SHARE IJ Volume 2",
            "description" => "Second issue with cutting-edge research papers.",
            "year" => 2025,
            "issue_number" => 2,
            "status" => "published",
            "published_at" => now(),
        ]);

        Paper::create([
            "user_id" => $author->id,
            "volume_id" => $volume1->id,
            "title" => "Machine Learning in Healthcare",
            "abstract" => "This paper explores the application of machine learning algorithms in healthcare diagnostics and patient care optimization.",
            "authors" => "Jane Researcher, John Doe",
            "keywords" => "Machine Learning, Healthcare, AI, Diagnostics",
            "document_path" => "papers/sample1.pdf",
            "status" => "published",
            "submitted_at" => now()->subMonths(8),
            "published_at" => now()->subMonths(6),
        ]);

        Paper::create([
            "user_id" => $author->id,
            "volume_id" => $volume2->id,
            "title" => "AI in Education",
            "abstract" => "This research examines the transformative impact of artificial intelligence on modern education systems.",
            "authors" => "Jane Researcher",
            "keywords" => "AI, Education, EdTech",
            "document_path" => "papers/sample2.pdf",
            "status" => "published",
            "submitted_at" => now()->subMonths(2),
            "published_at" => now(),
        ]);

        // Blog Categories
        $announcements = PostCategory::create([
            "name" => "Announcements",
            "slug" => "announcements",
        ]);

        $research = PostCategory::create([
            "name" => "Research News",
            "slug" => "research-news",
        ]);

        // Blog Posts
        Post::create([
            "user_id" => $admin->id,
            "post_category_id" => $announcements->id,
            "title" => "Welcome to SHARE IJ",
            "slug" => "welcome-to-shareij",
            "content" => "<p>We are excited to announce the launch of SHARE IJ, a peer-reviewed academic journal dedicated to publishing high-quality research across various disciplines.</p><p>Our mission is to provide a platform for researchers worldwide to share their findings and contribute to the advancement of knowledge.</p>",
            "status" => "published",
            "published_at" => now()->subDays(30),
        ]);

        Post::create([
            "user_id" => $admin->id,
            "post_category_id" => $announcements->id,
            "title" => "Call for Papers - Volume 3",
            "slug" => "call-for-papers-volume-3",
            "content" => "<p>We are now accepting submissions for Volume 3 of SHARE IJ. Submit your research papers for peer review.</p><p>Deadline: March 31, 2026</p>",
            "status" => "published",
            "published_at" => now()->subDays(7),
        ]);

        Post::create([
            "user_id" => $admin->id,
            "post_category_id" => $research->id,
            "title" => "New Research Trends in AI",
            "slug" => "new-research-trends-in-ai",
            "content" => "<p>Artificial Intelligence continues to evolve rapidly. Here are the latest trends shaping the field in 2026.</p>",
            "status" => "published",
            "published_at" => now()->subDays(3),
        ]);

        // Settings
        Setting::create(["key" => "site_name", "value" => "SHARE IJ"]);
        Setting::create(["key" => "site_email", "value" => "info@shareij.com"]);
        Setting::create(["key" => "site_phone", "value" => "+1 234 567 890"]);

        // Email Templates
        EmailTemplate::create([
            "name" => "paper_submitted_author",
            "subject" => "Paper Submitted Successfully - {paper_title}",
            "body" => "<h2>Paper Submission Confirmation</h2><p>Dear {author_name},</p><p>Your paper <strong>{paper_title}</strong> has been successfully submitted to SHARE IJ.</p><p><strong>Authors:</strong> {authors}<br><strong>Submitted:</strong> {submitted_date}</p><p>Our editorial team will review your submission and you will be notified of any updates.</p><p>You can track your submission status in your <a href=\"{dashboard_url}\">Dashboard</a>.</p><p>Thank you for choosing SHARE IJ.</p><p>Best regards,<br>SHARE IJ Editorial Team</p>",
            "description" => "Sent to author when they submit a new paper",
            "is_active" => true,
        ]);

        EmailTemplate::create([
            "name" => "paper_submitted_editor",
            "subject" => "New Paper Submission - {paper_title}",
            "body" => "<h2>New Paper Submission</h2><p>A new paper has been submitted to SHARE IJ and requires your attention.</p><p><strong>Title:</strong> {paper_title}<br><strong>Authors:</strong> {authors}<br><strong>Submitter:</strong> {submitter_name} ({submitter_email})<br><strong>Submitted:</strong> {submitted_date}</p><p><strong>Abstract:</strong></p><p>{abstract}</p><p><a href=\"{review_url}\">Review this paper in Admin Panel</a></p>",
            "description" => "Sent to editors when a new paper is submitted",
            "is_active" => true,
        ]);

        EmailTemplate::create([
            "name" => "paper_status_changed",
            "subject" => "Paper Status Update - {paper_title}",
            "body" => "<h2>Paper Status Update</h2><p>Dear {author_name},</p><p>The status of your paper <strong>{paper_title}</strong> has been updated.</p><p><strong>Previous Status:</strong> {old_status}<br><strong>New Status:</strong> {new_status}</p><p>You can view more details in your <a href=\"{dashboard_url}\">Dashboard</a>.</p><p>If you have any questions, please contact our editorial team.</p><p>Best regards,<br>SHARE IJ Editorial Team</p>",
            "description" => "Sent to author when paper status changes",
            "is_active" => true,
        ]);

        EmailTemplate::create([
            "name" => "reviewer_assigned",
            "subject" => "Review Request - {paper_title}",
            "body" => "<h2>Review Request</h2><p>Dear {reviewer_name},</p><p>You have been assigned to review the following paper:</p><p><strong>Title:</strong> {paper_title}<br><strong>Authors:</strong> {authors}<br><strong>Keywords:</strong> {keywords}</p><p><strong>Abstract:</strong></p><p>{abstract}</p><p><a href=\"{review_url}\">Access the paper for review</a></p><p>Please complete your review within 21 days.</p><p>Best regards,<br>SHARE IJ Editorial Team</p>",
            "description" => "Sent to reviewer when assigned to review a paper",
            "is_active" => true,
        ]);
    }
}
