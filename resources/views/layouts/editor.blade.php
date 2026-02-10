<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reviewer Panel') - SHARE IJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #2c5282 0%, #1a365d 100%); }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin: 4px 12px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.15); color: #fff; }
        .main-content { background: #f8fafc; min-height: 100vh; }
        .stat-card { border-radius: 12px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .stat-card .icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .table th { font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4">
            <div class="text-center mb-4">
                <h5 class="text-white"><i class="fas fa-book-open me-2"></i> SHARE IJ</h5>
                <small class="text-white-50">Reviewer Panel</small>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('editor') ? 'active' : '' }}" href="{{ route('editor.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('editor/papers*') ? 'active' : '' }}" href="{{ route('editor.papers.index') }}">
                        <i class="fas fa-file-alt me-2"></i> Papers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('editor/reviews*') ? 'active' : '' }}" href="{{ route('editor.reviews.index') }}">
                        <i class="fas fa-check-circle me-2"></i> Reviews
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-globe me-2"></i> View Site
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content py-4">
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>