<?php

use App\Http\Controllers\Admin\AppearanceController as AdminAppearance;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\EmailTemplateController as AdminEmailTemplate;
use App\Http\Controllers\Admin\MenuController as AdminMenu;
use App\Http\Controllers\Admin\MessageController as AdminMessage;
use App\Http\Controllers\Admin\PageController as AdminPage;
use App\Http\Controllers\Admin\PaperController as AdminPaper;
use App\Http\Controllers\Admin\PostController as AdminPost;
use App\Http\Controllers\Admin\ReviewController as AdminReview;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\VolumeController as AdminVolume;
use App\Http\Controllers\Editor\DashboardController as EditorDashboard;
use App\Http\Controllers\Editor\PaperController as EditorPaper;
use App\Http\Controllers\Editor\ReviewController as EditorReview;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/editorial-board', [HomeController::class, 'editorialBoard'])->name('editorial-board');
Route::get('/call-for-papers', [HomeController::class, 'callForPapers'])->name('call-for-papers');
Route::get('/author-guidelines', [HomeController::class, 'authorGuidelines'])->name('author-guidelines');
Route::get('/research-areas', [HomeController::class, 'researchAreas'])->name('research-areas');
Route::get('/submission-workflow', [HomeController::class, 'submissionWorkflow'])->name('submission-workflow');
Route::get('/article-processing-charges', [HomeController::class, 'apc'])->name('apc');

// Volumes
Route::get('/volumes', [VolumeController::class, 'index'])->name('volumes.index');
Route::get('/volumes/{volume}', [VolumeController::class, 'show'])->name('volumes.show');

// Papers
Route::get('/papers/{paper}', [PaperController::class, 'show'])->name('papers.show');
Route::get('/papers/{paper}/download', [PaperController::class, 'download'])->name('papers.download');

// Blog
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('blog.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Dynamic CMS Pages (catch-all for custom pages - must be after all named routes)
Route::get('/page/{page:slug}', function (\App\Models\Page $page) {
    if (!$page->is_published) abort(404);
    return view('pages.show', compact('page'));
})->name('page.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', function () { return view('auth.register'); })->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Author Dashboard
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        $papers = auth()->user()->papers;
        return view('dashboard.index', compact('papers'));
    })->name('index');
    Route::resource('papers', PaperController::class)->except(['show']);
    Route::get('papers/{paper}/certificate', [PaperController::class, 'certificate'])->name('papers.certificate');
    Route::get('reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/paper/{paper}', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::get('reviews/{review}', [App\Http\Controllers\ReviewController::class, 'show'])->name('reviews.show');
    Route::post('reviews/{paper}', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

// Editor Routes
Route::middleware(['auth', 'editor'])->prefix('editor')->name('editor.')->group(function () {
    Route::get('/', [EditorDashboard::class, 'index'])->name('dashboard');
    Route::get('papers', [EditorPaper::class, 'index'])->name('papers.index');
    Route::get('papers/{paper}', [EditorPaper::class, 'show'])->name('papers.show');
    Route::put('papers/{paper}', [EditorPaper::class, 'update'])->name('papers.update');
    Route::get('reviews', [EditorReview::class, 'index'])->name('reviews.index');
});

// Admin Routes - Only for admin role
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('volumes', AdminVolume::class);
    Route::resource('papers', AdminPaper::class);
    Route::post('papers/{paper}/assign-reviewer', [AdminPaper::class, 'assignReviewer'])->name('papers.assign-reviewer');
    Route::resource('reviews', AdminReview::class)->only(['index', 'show', 'destroy']);
    Route::resource('users', AdminUser::class);
    Route::get('papers/{paper}/download', [AdminPaper::class, 'download'])->name('papers.download');
    Route::resource('posts', AdminPost::class);
    Route::resource('messages', AdminMessage::class)->only(['index', 'show', 'destroy']);
    Route::patch('messages/{message}/read', [AdminMessage::class, 'markAsRead'])->name('messages.read');
    Route::get('settings', [AdminSetting::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSetting::class, 'update'])->name('settings.update');
    
    // Email Templates
    Route::get('email-templates', [AdminEmailTemplate::class, 'index'])->name('email-templates.index');
    Route::get('email-templates/{emailTemplate}/edit', [AdminEmailTemplate::class, 'edit'])->name('email-templates.edit');
    Route::put('email-templates/{emailTemplate}', [AdminEmailTemplate::class, 'update'])->name('email-templates.update');
    Route::get('email-templates/{emailTemplate}/preview', [AdminEmailTemplate::class, 'preview'])->name('email-templates.preview');
    Route::patch('email-templates/{emailTemplate}/toggle', [AdminEmailTemplate::class, 'toggleStatus'])->name('email-templates.toggle');
    Route::post('email-templates/{emailTemplate}/test', [AdminEmailTemplate::class, 'testEmail'])->name('email-templates.test');
    
    // CMS - Pages
    Route::resource('pages', AdminPage::class);
    
    // CMS - Menus
    Route::resource('menus', AdminMenu::class);
    Route::post('menus/reorder', [AdminMenu::class, 'reorder'])->name('menus.reorder');
    
    // CMS - Appearance  
    Route::get('appearance', [AdminAppearance::class, 'index'])->name('appearance.index');
    Route::post('appearance', [AdminAppearance::class, 'update'])->name('appearance.update');
});