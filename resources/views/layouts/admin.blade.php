<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - SHARE IJ Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a5f 0%, #0d2137 100%);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .8);
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 24px;
        }

        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .stat-card .icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, .15);
            margin: 1rem 1rem;
        }

        .sidebar-heading {
            color: rgba(255, 255, 255, .4);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 1.5rem;
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block sidebar py-4">
                <div class="text-center mb-4">
                    <h5 class="text-white"><i class="fas fa-book-open"></i> SHARE IJ</h5>
                    <small class="text-white-50">Admin Panel</small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin') && !request()->is('admin/*') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                    <div class="sidebar-heading">Content</div>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/volumes*') ? 'active' : '' }}"
                            href="{{ route('admin.volumes.index') }}">
                            <i class="fas fa-book"></i> Volumes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/papers*') ? 'active' : '' }}"
                            href="{{ route('admin.papers.index') }}">
                            <i class="fas fa-file-alt"></i> Papers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/reviews*') ? 'active' : '' }}"
                            href="{{ route('admin.reviews.index') }}">
                            <i class="fas fa-clipboard-check"></i> Reviews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/posts*') ? 'active' : '' }}"
                            href="{{ route('admin.posts.index') }}">
                            <i class="fas fa-newspaper"></i> Blog Posts
                        </a>
                    </li>

                    <div class="sidebar-heading">Users & Messages</div>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/messages*') ? 'active' : '' }}"
                            href="{{ route('admin.messages.index') }}">
                            <i class="fas fa-envelope"></i> Messages
                        </a>
                    </li>

                    <div class="sidebar-heading">System</div>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/review-templates*') ? 'active' : '' }}"
                            href="{{ route('admin.review-templates.index') }}">
                            <i class="fas fa-list-alt"></i> Review Templates
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/email-templates*') ? 'active' : '' }}"
                            href="{{ route('admin.email-templates.index') }}">
                            <i class="fas fa-mail-bulk"></i> Email Templates
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}"
                            href="{{ route('admin.settings.index') }}">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </li>

                    <div class="sidebar-heading">Website CMS</div>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pages*') ? 'active' : '' }}"
                            href="{{ route('admin.pages.index') }}">
                            <i class="fas fa-file-alt"></i> Pages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/menus*') ? 'active' : '' }}"
                            href="{{ route('admin.menus.index') }}">
                            <i class="fas fa-bars"></i> Menus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/appearance*') ? 'active' : '' }}"
                            href="{{ route('admin.appearance.index') }}">
                            <i class="fas fa-palette"></i> Appearance
                        </a>
                    </li>

                    <div class="sidebar-divider"></div>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-globe"></i> View Site
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-start w-100">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <main class="col-md-10 ms-sm-auto main-content px-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4">
                    <h2>@yield('page-title', 'Dashboard')</h2>
                    @yield('page-actions')
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>