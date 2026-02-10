<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing menus
        Menu::truncate();

        // ===== HEADER MENUS =====
        Menu::create(['title' => 'Home', 'route_name' => 'home', 'location' => 'header', 'sort_order' => 1, 'is_active' => true]);
        Menu::create(['title' => 'About', 'route_name' => 'about', 'location' => 'header', 'sort_order' => 2, 'is_active' => true]);
        Menu::create(['title' => 'Editorial Team', 'route_name' => 'editorial-board', 'location' => 'header', 'sort_order' => 3, 'is_active' => true]);

        // For Authors dropdown
        $forAuthors = Menu::create(['title' => 'For Authors', 'url' => '#', 'location' => 'header', 'sort_order' => 4, 'is_active' => true]);
        Menu::create(['title' => 'Call for Papers', 'route_name' => 'call-for-papers', 'location' => 'header', 'parent_id' => $forAuthors->id, 'sort_order' => 1, 'icon' => 'fas fa-bullhorn', 'is_active' => true]);
        Menu::create(['title' => 'Author Guidelines', 'route_name' => 'author-guidelines', 'location' => 'header', 'parent_id' => $forAuthors->id, 'sort_order' => 2, 'icon' => 'fas fa-file-alt', 'is_active' => true]);
        Menu::create(['title' => 'Subject Areas', 'route_name' => 'research-areas', 'location' => 'header', 'parent_id' => $forAuthors->id, 'sort_order' => 3, 'icon' => 'fas fa-microscope', 'is_active' => true]);
        Menu::create(['title' => 'Submission Workflow', 'route_name' => 'submission-workflow', 'location' => 'header', 'parent_id' => $forAuthors->id, 'sort_order' => 4, 'icon' => 'fas fa-tasks', 'is_active' => true]);
        Menu::create(['title' => 'Publication Charges', 'route_name' => 'apc', 'location' => 'header', 'parent_id' => $forAuthors->id, 'sort_order' => 5, 'icon' => 'fas fa-coins', 'is_active' => true]);
        Menu::create(['title' => 'Copyright Form Download', 'url' => '/downloads/copyright-form.pdf', 'location' => 'header', 'parent_id' => $forAuthors->id, 'sort_order' => 6, 'icon' => 'fas fa-file-contract', 'is_active' => true]);
        Menu::create(['title' => 'Paper Format Download', 'url' => '/downloads/paper-format.docx', 'location' => 'header', 'parent_id' => $forAuthors->id, 'sort_order' => 7, 'icon' => 'fas fa-file-word', 'is_active' => true]);

        Menu::create(['title' => 'Archives', 'route_name' => 'volumes.index', 'location' => 'header', 'sort_order' => 5, 'is_active' => true]);
        Menu::create(['title' => 'Contact', 'route_name' => 'contact', 'location' => 'header', 'sort_order' => 6, 'is_active' => true]);

        // ===== FOOTER MENUS =====
        $quickLinks = Menu::create(['title' => 'Quick Links', 'url' => '#', 'location' => 'footer', 'sort_order' => 1, 'is_active' => true]);
        Menu::create(['title' => 'Home', 'route_name' => 'home', 'location' => 'footer', 'parent_id' => $quickLinks->id, 'sort_order' => 1, 'is_active' => true]);
        Menu::create(['title' => 'About Journal', 'route_name' => 'about', 'location' => 'footer', 'parent_id' => $quickLinks->id, 'sort_order' => 2, 'is_active' => true]);
        Menu::create(['title' => 'Editorial Team', 'route_name' => 'editorial-board', 'location' => 'footer', 'parent_id' => $quickLinks->id, 'sort_order' => 3, 'is_active' => true]);
        Menu::create(['title' => 'Archives', 'route_name' => 'volumes.index', 'location' => 'footer', 'parent_id' => $quickLinks->id, 'sort_order' => 4, 'is_active' => true]);
        Menu::create(['title' => 'Contact', 'route_name' => 'contact', 'location' => 'footer', 'parent_id' => $quickLinks->id, 'sort_order' => 5, 'is_active' => true]);

        $forAuthorsFooter = Menu::create(['title' => 'For Authors', 'url' => '#', 'location' => 'footer', 'sort_order' => 2, 'is_active' => true]);
        Menu::create(['title' => 'Call for Papers', 'route_name' => 'call-for-papers', 'location' => 'footer', 'parent_id' => $forAuthorsFooter->id, 'sort_order' => 1, 'is_active' => true]);
        Menu::create(['title' => 'Author Guidelines', 'route_name' => 'author-guidelines', 'location' => 'footer', 'parent_id' => $forAuthorsFooter->id, 'sort_order' => 2, 'is_active' => true]);
        Menu::create(['title' => 'Submission Workflow', 'route_name' => 'submission-workflow', 'location' => 'footer', 'parent_id' => $forAuthorsFooter->id, 'sort_order' => 3, 'is_active' => true]);
        Menu::create(['title' => 'Publication Charges', 'route_name' => 'apc', 'location' => 'footer', 'parent_id' => $forAuthorsFooter->id, 'sort_order' => 4, 'is_active' => true]);
        Menu::create(['title' => 'Copyright Form', 'url' => '/downloads/copyright-form.pdf', 'location' => 'footer', 'parent_id' => $forAuthorsFooter->id, 'sort_order' => 5, 'is_active' => true]);
        Menu::create(['title' => 'Paper Format', 'url' => '/downloads/paper-format.docx', 'location' => 'footer', 'parent_id' => $forAuthorsFooter->id, 'sort_order' => 6, 'is_active' => true]);
        Menu::create(['title' => 'Submit Paper', 'route_name' => 'register', 'location' => 'footer', 'parent_id' => $forAuthorsFooter->id, 'sort_order' => 7, 'is_active' => true]);
    }
}
