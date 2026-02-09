<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Announcements', 'slug' => 'announcements', 'description' => 'Journal announcements and news'],
            ['name' => 'Research', 'slug' => 'research', 'description' => 'Research highlights and discoveries'],
            ['name' => 'Events', 'slug' => 'events', 'description' => 'Conferences and events'],
            ['name' => 'Tutorials', 'slug' => 'tutorials', 'description' => 'Writing and submission tutorials'],
        ];

        foreach ($categories as $cat) {
            PostCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $admin = User::where('role', 'admin')->first();

        $posts = [
            [
                'title' => 'Welcome to DE-Journal',
                'slug' => 'welcome-to-de-journal',
                'content' => '<p>Welcome to DE-Journal, your premier destination for academic research and publications. We are committed to advancing knowledge and fostering academic excellence through peer-reviewed publications.</p>
                <p>Our journal covers a wide range of disciplines and welcomes submissions from researchers worldwide. We strive to maintain the highest standards of academic integrity and scientific rigor.</p>
                <h3>Our Mission</h3>
                <p>To provide a platform for researchers to share their findings with the global academic community, fostering collaboration and innovation across disciplines.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(30),
                'post_category_id' => 1,
            ],
            [
                'title' => 'Call for Papers: Special Issue on AI',
                'slug' => 'call-for-papers-ai-special-issue',
                'content' => '<p>We are pleased to announce a special issue focusing on Artificial Intelligence and its applications across various domains.</p>
                <h3>Topics of Interest</h3>
                <ul>
                    <li>Machine Learning and Deep Learning</li>
                    <li>Natural Language Processing</li>
                    <li>Computer Vision</li>
                    <li>AI Ethics and Governance</li>
                </ul>
                <p><strong>Submission Deadline:</strong> December 31, 2025</p>',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'post_category_id' => 1,
            ],
            [
                'title' => 'New Peer Review Guidelines',
                'slug' => 'new-peer-review-guidelines',
                'content' => '<p>We have updated our peer review guidelines to ensure fair and constructive feedback for all authors.</p>
                <p>Key changes include:</p>
                <ul>
                    <li>Extended review timeline of 4 weeks</li>
                    <li>Structured feedback forms</li>
                    <li>Double-blind review process</li>
                </ul>',
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'post_category_id' => 1,
            ],
        ];

        foreach ($posts as $postData) {
            $postData['user_id'] = $admin ? $admin->id : 1;
            Post::updateOrCreate(['slug' => $postData['slug']], $postData);
        }
    }
}