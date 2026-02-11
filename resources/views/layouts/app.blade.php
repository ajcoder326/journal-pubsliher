<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($siteSettings['site_name'] ?? 'SHARE IJ') . ' - ' . ($siteSettings['journal_full_title'] ?? 'Share International Journal'))</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Share International Journal of Sustainable Engineering, Management and Social Sciences - A multidisciplinary, peer-reviewed, open access scholarly journal.')">
    @if(!empty($siteSettings['meta_keywords']))
    <meta name="keywords" content="{{ $siteSettings['meta_keywords'] }}">
    @endif
    @if(!empty($siteSettings['site_favicon']))
    <link rel="icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: {{ $siteSettings['theme_primary_color'] ?? '#0d2b4e' }};
            --primary-light: {{ isset($siteSettings['theme_primary_color']) ? $siteSettings['theme_primary_color'] . 'cc' : '#164677' }};
            --secondary: {{ $siteSettings['theme_secondary_color'] ?? '#d4a437' }};
            --accent: {{ $siteSettings['theme_accent_color'] ?? '#1a73e8' }};
            --success: #0f9d58;
            --bg-light: #f7f9fc;
            --text-dark: {{ $siteSettings['theme_text_color'] ?? '#1a1a2e' }};
            --text-muted: #6c757d;
            --border-color: #e8ecf1;
            --radius: 12px;
        }

        * { box-sizing: border-box; }

        img, svg { max-width: 100%; height: auto; }

        html, body { overflow-x: hidden; max-width: 100vw; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-dark);
            background: #fff;
            line-height: 1.4;
        }

        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; font-weight: 600; }

        /* Top Bar */
        .top-bar {
            background: var(--primary);
            color: rgba(255,255,255,0.85);
            font-size: 0.8rem;
            padding: 6px 0;
        }
        .top-bar a { color: var(--secondary); text-decoration: none; }
        .top-bar a:hover { color: #fff; }

        /* Navbar */
        .navbar { background: #fff; border-bottom: 2px solid var(--secondary); }
        .navbar-brand { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.1rem; color: var(--primary) !important; line-height: 1.3; white-space: normal; word-break: break-word; }
        .navbar-brand small { display: block; font-family: 'Inter', sans-serif; font-size: 0.55rem; font-weight: 400; letter-spacing: 0.5px; color: var(--text-muted); text-transform: uppercase; }
        .nav-link { font-weight: 500; font-size: 0.88rem; padding: 0.5rem 0.75rem !important; color: var(--text-dark) !important; position: relative; transition: color 0.2s; }
        .nav-link:hover, .nav-link.active { color: var(--accent) !important; }
        .nav-link.active::after { content: ''; position: absolute; bottom: 0; left: 0.75rem; right: 0.75rem; height: 2px; background: var(--secondary); }

        .dropdown-menu { border: 1px solid var(--border-color); border-radius: var(--radius); box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 0.5rem; }
        .dropdown-item { border-radius: 8px; padding: 0.5rem 1rem; font-size: 0.87rem; }
        .dropdown-item:hover { background: var(--bg-light); }

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--accent) 100%);
            color: white;
            padding: 70px 0;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%);
            border-radius: 50%;
        }
        .hero-section .lead { font-size: 1.1rem; opacity: 0.9; }
        .hero-section .badge { white-space: normal; line-height: 1.2; max-width: 100%; }
        .hero-section h1 { word-break: break-word; }
        .hero-section .btn { white-space: normal; }

        /* Section */
        .section-title { position: relative; padding-bottom: 15px; margin-bottom: 35px; color: var(--primary); }
        .section-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background: var(--secondary); border-radius: 2px; }
        .section-title.text-center::after { left: 50%; transform: translateX(-50%); }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            padding: 50px 0 40px;
        }
        .page-header h1 { font-size: 2rem; margin-bottom: 0.5rem; word-break: break-word; }
        .breadcrumb { flex-wrap: wrap; }
        .page-header .breadcrumb { margin-bottom: 0; }
        .page-header .breadcrumb-item a { color: var(--secondary); text-decoration: none; }
        .page-header .breadcrumb-item.active { color: rgba(255,255,255,0.7); }

        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.08); }
        .card-header { background: var(--bg-light); border-bottom: 1px solid var(--border-color); font-weight: 600; }

        .feature-card { text-align: center; padding: 2rem 1.5rem; }
        .feature-card .icon-wrap {
            width: 64px; height: 64px; border-radius: 16px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--accent), var(--primary-light));
            color: #fff;
        }

        .paper-card { border-left: 4px solid var(--accent); }

        /* Buttons */
        .btn-primary { background: var(--primary); border-color: var(--primary); font-weight: 500; border-radius: 8px; padding: 0.5rem 1.5rem; }
        .btn-primary:hover { background: var(--primary-light); border-color: var(--primary-light); }
        .btn-accent { background: var(--secondary); border-color: var(--secondary); color: var(--primary); font-weight: 600; border-radius: 8px; }
        .btn-accent:hover { background: #c0932f; border-color: #c0932f; color: #fff; }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500; }
        .btn-outline-primary:hover { background: var(--primary); }

        /* Sidebar */
        .sidebar { background: var(--bg-light); padding: 1.5rem; border-radius: var(--radius); border: 1px solid var(--border-color); }
        .sidebar h5 { font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: var(--primary); }

        /* Info Box */
        .info-box { background: var(--bg-light); border-radius: var(--radius); padding: 1.5rem; border-left: 4px solid var(--secondary); margin-bottom: 1.5rem; }

        /* Badge */
        .badge-journal { background: rgba(26,115,232,0.1); color: var(--accent); font-weight: 500; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.78rem; }

        /* Footer */
        .footer {
            background: var(--primary);
            color: rgba(255,255,255,0.85);
            padding: 50px 0 20px;
        }
        .footer h5, .footer h6 { color: #fff; font-family: 'Inter', sans-serif; font-weight: 600; }
        .footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s; }
        .footer a:hover { color: var(--secondary); }
        .footer .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; margin-top: 30px; font-size: 0.85rem; }
        .footer .social-link {
            width: 36px; height: 36px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.1); color: #fff; transition: all 0.3s;
        }
        .footer .social-link:hover { background: var(--secondary); color: var(--primary); }

        /* Workflow */
        .workflow-step { position: relative; padding-left: 60px; margin-bottom: 2rem; }
        .workflow-step .step-number {
            position: absolute; left: 0; top: 0;
            width: 42px; height: 42px; border-radius: 50%;
            background: var(--accent); color: #fff; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .workflow-step::before {
            content: '';
            position: absolute; left: 20px; top: 42px; bottom: -2rem;
            width: 2px; background: var(--border-color);
        }
        .workflow-step:last-child::before { display: none; }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-section { padding: 50px 0; }
            .hero-section h1 { font-size: 1.8rem; }
        }
        @media (max-width: 767px) {
            .hero-section { padding: 30px 0; }
            .hero-section h1 { font-size: 1.5rem; }
            .hero-section .lead { font-size: 0.95rem; }
            .hero-section .btn { font-size: 0.85rem; padding: 8px 16px; }
            .top-bar .d-flex { flex-wrap: wrap; gap: 4px; }
            .top-bar span { font-size: 0.7rem; }
            .navbar-brand { font-size: 1rem !important; }
            .navbar-brand small { display: none; }
            .section-title { font-size: 1.3rem; }
            .card-body { padding: 1rem; }
            .footer-section { padding: 30px 0 !important; }
            .footer-section h5 { font-size: 1rem; }
            table { font-size: 0.85rem; }
            .container { padding-left: 12px; padding-right: 12px; }
        }

        .status-badge { font-size: 0.75rem; padding: 0.25rem 0.5rem; }
        .text-muted-light { color: rgba(255,255,255,0.7) !important; }

        /* APC Table */
        .apc-table th { background: var(--primary); color: #fff; }
    </style>
    @if(!empty($siteSettings['custom_css']))
    <style>{{ $siteSettings['custom_css'] }}</style>
    @endif
    @if(!empty($siteSettings['custom_head_code']))
    {!! $siteSettings['custom_head_code'] !!}
    @endif
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-envelope me-1"></i> <a href="mailto:{{ $siteSettings['contact_email'] ?? 'editor@shareij.org' }}">{{ $siteSettings['contact_email'] ?? 'editor@shareij.org' }}</a>
                <span class="mx-2">|</span>
                <span>{{ $siteSettings['header_issn'] ?? 'ISSN: Applied' }}</span>
                <span class="mx-2">|</span>
                <span>{{ $siteSettings['header_frequency'] ?? 'Frequency: Monthly e-Journal' }}</span>
                @if(!empty($siteSettings['header_top_bar_text']))
                    <span class="mx-2">|</span>
                    <span>{{ $siteSettings['header_top_bar_text'] }}</span>
                @endif
            </div>
            <div>
                <a href="{{ route('author-guidelines') }}" class="me-3">Author Guidelines</a>
                <a href="{{ route('register') }}">Submit Manuscript</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(!empty($siteSettings['site_logo']))
                    <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['header_brand_name'] ?? 'SHARE IJ' }}" style="max-height: 50px;" class="me-2">
                @elseif(file_exists(public_path('images/share-ij-logo.png')))
                    <img src="{{ asset('images/share-ij-logo.png') }}" alt="{{ $siteSettings['header_brand_name'] ?? 'SHARE IJ' }}" style="max-height: 50px;" class="me-2">
                @else
                    <i class="fas fa-book-open me-2 text-primary"></i>
                    {{ $siteSettings['header_brand_name'] ?? ($siteSettings['site_name'] ?? 'SHARE IJ') }}
                    <small>{{ $siteSettings['header_brand_subtitle'] ?? ($siteSettings['journal_full_title'] ?? 'Share International Journal of Sustainable Engineering, Management & Social Sciences') }}</small>
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(isset($siteHeaderMenus) && $siteHeaderMenus->count())
                        @foreach($siteHeaderMenus as $menuItem)
                            @if($menuItem->children->count())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    @if($menuItem->icon)<i class="{{ $menuItem->icon }} me-1"></i>@endif{{ $menuItem->title }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($menuItem->children as $child)
                                    <li><a class="dropdown-item" href="{{ $child->resolved_url }}" target="{{ $child->target }}">@if($child->icon)<i class="{{ $child->icon }} me-2 text-muted"></i>@endif{{ $child->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $menuItem->resolved_url }}" target="{{ $menuItem->target }}">
                                    @if($menuItem->icon)<i class="{{ $menuItem->icon }} me-1"></i>@endif{{ $menuItem->title }}
                                </a>
                            </li>
                            @endif
                        @endforeach
                    @else
                        {{-- Default fallback menus --}}
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                                <li class="nav-item"><a class="nav-link {{ request()->routeIs('editorial-board') ? 'active' : '' }}" href="{{ route('editorial-board') }}">Editorial Board</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('call-for-papers') || request()->routeIs('author-guidelines') || request()->routeIs('research-areas') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">For Authors</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('call-for-papers') }}"><i class="fas fa-bullhorn me-2 text-muted"></i>Call for Papers</a></li>
                                <li><a class="dropdown-item" href="{{ route('author-guidelines') }}"><i class="fas fa-file-alt me-2 text-muted"></i>Author Guidelines</a></li>
                                <li><a class="dropdown-item" href="{{ route('research-areas') }}"><i class="fas fa-microscope me-2 text-muted"></i>Subject Areas</a></li>
                                <li><a class="dropdown-item" href="{{ route('submission-workflow') }}"><i class="fas fa-tasks me-2 text-muted"></i>Submission Workflow</a></li>
                                <li><a class="dropdown-item" href="{{ route('apc') }}"><i class="fas fa-coins me-2 text-muted"></i>Publication Charges</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/downloads/copyright-form.pdf"><i class="fas fa-file-contract me-2 text-muted"></i>Copyright Form Download</a></li>
                                <li><a class="dropdown-item" href="/downloads/paper-format.docx"><i class="fas fa-file-word me-2 text-muted"></i>Paper Format Download</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('volumes.*') ? 'active' : '' }}" href="{{ route('volumes.index') }}">Archives</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                    @endif
                </ul>
                <div class="ms-lg-3">
                    @guest
                        <a class="btn btn-accent btn-sm" href="{{ route('register') }}"><i class="fas fa-paper-plane me-1"></i> Submit Paper</a>
                    @else
                        <div class="dropdown">
                            <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Admin Panel</a></li>
                                @elseif(in_array(Auth::user()->role, ['editor', 'editor_in_chief']))
                                    <li><a class="dropdown-item" href="{{ route('editor.dashboard') }}"><i class="fas fa-edit me-2"></i>Reviewer Panel</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('dashboard.index') }}"><i class="fas fa-user me-2"></i>My Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    @if(file_exists(public_path('images/share-ij-footer-logo.png')))
                        <img src="{{ asset('images/share-ij-footer-logo.png') }}" alt="" style="max-height: 270px; margin-top: -10px;" class="me-2">
                    @elseif(file_exists(public_path('images/share-ij-logo.png')))
                        <img src="{{ asset('images/share-ij-logo.png') }}" alt="" style="max-height: 270px; margin-top: -10px;" class="me-2">
                    @endif
                </div>
                @if(isset($siteFooterMenus) && $siteFooterMenus->count())
                    @foreach($siteFooterMenus as $footerGroup)
                    <div class="col-md-2 mb-4">
                        <h6>{{ $footerGroup->title }}</h6>
                        @if($footerGroup->children->count())
                        <ul class="list-unstyled small">
                            @foreach($footerGroup->children as $fChild)
                            <li class="mb-1"><a href="{{ $fChild->resolved_url }}" target="{{ $fChild->target }}">{{ $fChild->title }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endforeach
                @else
                    {{-- Default fallback footer --}}
                    <div class="col-md-2 mb-4">
                        <h6>Quick Links</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-1"><a href="{{ route('home') }}">Home</a></li>
                            <li class="mb-1"><a href="{{ route('about') }}">About Journal</a></li>
                            <li class="mb-1"><a href="{{ route('editorial-board') }}">Editorial Board</a></li>
                            <li class="mb-1"><a href="{{ route('volumes.index') }}">Archives</a></li>
                            <li class="mb-1"><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-4">
                        <h6>For Authors</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-1"><a href="{{ route('call-for-papers') }}">Call for Papers</a></li>
                            <li class="mb-1"><a href="{{ route('author-guidelines') }}">Author Guidelines</a></li>
                            <li class="mb-1"><a href="{{ route('submission-workflow') }}">Submission Workflow</a></li>
                            <li class="mb-1"><a href="{{ route('apc') }}">Publication Charges</a></li>
                            <li class="mb-1"><a href="/downloads/copyright-form.pdf">Copyright Form</a></li>
                            <li class="mb-1"><a href="/downloads/paper-format.docx">Paper Format</a></li>
                            <li class="mb-1"><a href="{{ route('register') }}">Submit Paper</a></li>
                        </ul>
                    </div>
                @endif
                <div class="col-md-3 mb-4">
                    <h6>Contact</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i><a href="mailto:{{ $siteSettings['footer_email'] ?? ($siteSettings['contact_email'] ?? 'editor@shareij.org') }}">{{ $siteSettings['footer_email'] ?? ($siteSettings['contact_email'] ?? 'editor@shareij.org') }}</a></li>
                        <li class="mb-2"><i class="fas fa-building me-2"></i>{{ $siteSettings['footer_publisher_name'] ?? ($siteSettings['publisher_name'] ?? 'Share Study Hub') }}</li>
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>{{ $siteSettings['footer_address'] ?? ($siteSettings['address'] ?? '121, Shripuram Colony, Gurjar Ki Thadi, Jaipur, India') }}</li>
                    </ul>
                    <div class="d-flex gap-2">
                        @if(!empty($siteSettings['social_facebook']))<a href="{{ $siteSettings['social_facebook'] }}" class="social-link" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                        @if(!empty($siteSettings['social_twitter']))<a href="{{ $siteSettings['social_twitter'] }}" class="social-link" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                        @if(!empty($siteSettings['social_linkedin']))<a href="{{ $siteSettings['social_linkedin'] }}" class="social-link" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                        @if(!empty($siteSettings['social_scholar']))<a href="{{ $siteSettings['social_scholar'] }}" class="social-link" target="_blank"><i class="fab fa-google-scholar"></i></a>@endif
                        @if(empty($siteSettings['social_facebook']) && empty($siteSettings['social_twitter']) && empty($siteSettings['social_linkedin']) && empty($siteSettings['social_scholar']))
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-google-scholar"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center">
                @if(!empty($siteSettings['footer_copyright_text']))
                    <p class="mb-0">{{ $siteSettings['footer_copyright_text'] }}</p>
                @else
                    <p class="mb-0">&copy; {{ date('Y') }} {{ $siteSettings['journal_full_title'] ?? 'Share International Journal of Sustainable Engineering, Management and Social Sciences' }}. Published by <strong>{{ $siteSettings['footer_publisher_name'] ?? ($siteSettings['publisher_name'] ?? 'Share Study Hub') }}</strong>. All rights reserved.</p>
                @endif
                <p class="mb-0 mt-1" style="font-size:0.78rem;opacity:0.7"><i class="fas fa-shield-alt me-1"></i> {{ $siteSettings['footer_license_text'] ?? 'Content licensed under Creative Commons Attribution 4.0 International License.' }}</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>