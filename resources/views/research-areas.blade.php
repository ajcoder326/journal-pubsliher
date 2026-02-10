@extends('layouts.app')
@section('title', 'Subject Areas - SHARE IJ')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>Subject Areas Covered</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Subject Areas</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <p class="lead mb-5">SHARE IJ covers original research across the following broad disciplines with a focus on sustainability, innovation, and contemporary global issues.</p>

    <div class="row g-4">
        <!-- Engineering & Technology -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 4px solid var(--accent);">
                <div class="card-body">
                    <h4><i class="fas fa-cogs me-2 text-primary"></i>Engineering &amp; Technology</h4>
                    <div class="row mt-3">
                        <div class="col-6"><ul class="small">
                            <li>Civil Engineering</li><li>Mechanical Engineering</li><li>Electrical Engineering</li><li>Electronics & Communication</li><li>Computer Science & Engineering</li><li>Information Technology</li><li>AI and Data Science</li>
                        </ul></div>
                        <div class="col-6"><ul class="small">
                            <li>Environmental Engineering</li><li>Industrial & Production Engineering</li><li>Chemical Engineering</li><li>Biotechnology & Biomedical</li><li>Renewable Energy</li><li>Smart Systems & IoT</li>
                        </ul></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commerce & Management -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 4px solid var(--secondary);">
                <div class="card-body">
                    <h4><i class="fas fa-chart-line me-2 text-primary"></i>Commerce &amp; Management</h4>
                    <div class="row mt-3">
                        <div class="col-6"><ul class="small">
                            <li>Business Administration</li><li>Commerce & Accounting</li><li>Finance & Banking</li><li>Marketing Management</li><li>Human Resource Management</li><li>Operations & Supply Chain</li>
                        </ul></div>
                        <div class="col-6"><ul class="small">
                            <li>Strategic Management</li><li>Entrepreneurship & Innovation</li><li>International Business</li><li>Corporate Governance</li><li>Economics</li><li>Sustainability & ESG</li>
                        </ul></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Sciences -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 4px solid var(--success);">
                <div class="card-body">
                    <h4><i class="fas fa-users me-2 text-primary"></i>Social Sciences</h4>
                    <div class="row mt-3">
                        <div class="col-6"><ul class="small">
                            <li>Economics & Development Studies</li><li>Sociology</li><li>Political Science</li><li>Public Administration</li><li>Education & Educational Management</li><li>Psychology & Behavioral Studies</li>
                        </ul></div>
                        <div class="col-6"><ul class="small">
                            <li>Social Work</li><li>Gender & Women Studies</li><li>Demography & Population Studies</li><li>Rural and Urban Studies</li><li>Work-Life Balance</li>
                        </ul></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Law & Governance -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 4px solid #e74c3c;">
                <div class="card-body">
                    <h4><i class="fas fa-gavel me-2 text-primary"></i>Law &amp; Governance</h4>
                    <ul class="small mt-3">
                        <li>Constitutional Law</li><li>Corporate & Commercial Law</li><li>Environmental & Sustainability Law</li><li>Labour & Industrial Law</li><li>Human Rights & Social Justice</li><li>International Law</li><li>Public Policy & Regulatory Studies</li><li>Governance, Ethics & Compliance</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Humanities -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 4px solid #9b59b6;">
                <div class="card-body">
                    <h4><i class="fas fa-book me-2 text-primary"></i>Humanities</h4>
                    <ul class="small mt-3">
                        <li>English Literature & Language Studies</li><li>History & Cultural Studies</li><li>Philosophy & Ethics</li><li>Media & Communication Studies</li><li>Journalism & Mass Communication</li><li>Linguistics</li><li>Heritage & Cultural Sustainability</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Interdisciplinary -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 4px solid #1abc9c;">
                <div class="card-body">
                    <h4><i class="fas fa-project-diagram me-2 text-primary"></i>Interdisciplinary &amp; Other Areas</h4>
                    <ul class="small mt-3">
                        <li>Sustainable Development Studies</li><li>Environmental Studies</li><li>Climate Change & Policy Studies</li><li>Digital Society & Technology Studies</li><li>Research Methodology & Applied Statistics</li><li>Data Analytics & Decision Sciences</li><li>Multidisciplinary & Integrative Research</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('register') }}" class="btn btn-accent btn-lg"><i class="fas fa-paper-plane me-2"></i>Submit Your Research</a>
        <a href="{{ route('call-for-papers') }}" class="btn btn-outline-primary btn-lg ms-2">Call for Papers</a>
    </div>
</div>
@endsection
