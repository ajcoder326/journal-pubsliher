@extends('layouts.app')

@section('title', 'SIJSEMSS - Share International Journal of Sustainable Engineering, Management and Social Sciences')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2" style="font-size:0.85rem;">International | Open Access | Peer-Reviewed | Monthly</span>
                <h1 class="display-5 fw-bold mb-3">Share International Journal of Sustainable Engineering, Management &amp; Social Sciences</h1>
                <p class="lead mb-2">A multidisciplinary, scholarly journal published by <strong>Share Study Hub</strong> (Est. 2010)</p>
                <p class="mb-4" style="opacity:0.85;">"Knowledge Shared is Knowledge Squared" &mdash; Providing a global platform for researchers, academicians, and practitioners to disseminate original research and interdisciplinary perspectives.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('register') }}" class="btn btn-accent btn-lg"><i class="fas fa-paper-plane me-2"></i>Submit Manuscript</a>
                    <a href="{{ route('call-for-papers') }}" class="btn btn-outline-light btn-lg"><i class="fas fa-bullhorn me-2"></i>Call for Papers</a>
                    <a href="{{ route('volumes.index') }}" class="btn btn-outline-light btn-lg"><i class="fas fa-archive me-2"></i>Browse Archive</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <div class="p-4">
                    <div class="card border-0 shadow-lg" style="background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);border-radius:20px;">
                        <div class="card-body p-4 text-start text-white">
                            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Journal Details</h5>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>ISSN: Applied</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Double-Blind Peer Review</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>DOI for Every Article</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Open Access Publication</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Monthly Publication</li>
                                <li class="mb-0"><i class="fas fa-check-circle text-warning me-2"></i>UGC CARE Compliant</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Publish Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Why Publish With Us?</h2>
        <div class="row g-4">
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-coins"></i></div>
                    <h6>Affordable APC</h6>
                    <p class="small text-muted mb-0">Low-cost publication fees to support researchers worldwide.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-bolt"></i></div>
                    <h6>Rapid Peer Review</h6>
                    <p class="small text-muted mb-0">Quick and efficient review process without compromising quality.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-fingerprint"></i></div>
                    <h6>DOI Assigned</h6>
                    <p class="small text-muted mb-0">Every published article receives a unique Digital Object Identifier.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-globe"></i></div>
                    <h6>Open Access</h6>
                    <p class="small text-muted mb-0">High visibility and global dissemination of your research work.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-shield-alt"></i></div>
                    <h6>UGC CARE Compliant</h6>
                    <p class="small text-muted mb-0">Fully aligned with UGC CARE guidelines for academic recognition.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-search"></i></div>
                    <h6>SEO Optimized</h6>
                    <p class="small text-muted mb-0">Maximum online reach and impact for your published articles.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-certificate"></i></div>
                    <h6>Instant Certification</h6>
                    <p class="small text-muted mb-0">Receive Certificate of Publication immediately upon publishing.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-database"></i></div>
                    <h6>Comprehensive Indexing</h6>
                    <p class="small text-muted mb-0">Articles indexed in major online academic databases.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Current Issue -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Current Issue</h2>
        @if($latestVolume)
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">{{ $latestVolume->title }}</h4>
                        <p class="text-muted mb-0">Volume {{ $latestVolume->issue_number }}, {{ $latestVolume->year }}</p>
                    </div>
                    <a href="{{ route('volumes.show', $latestVolume) }}" class="btn btn-primary"><i class="fas fa-book-reader me-1"></i>View Issue</a>
                </div>
            </div>
        @else
            <div class="info-box"><i class="fas fa-info-circle me-2 text-primary"></i>First issue coming soon. <a href="{{ route('call-for-papers') }}">Submit your paper now!</a></div>
        @endif
    </div>
</section>

<!-- Recent Publications -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Recent Publications</h2>
        <div class="row g-4">
            @forelse($latestPapers as $paper)
                <div class="col-md-6">
                    <div class="card paper-card h-100">
                        <div class="card-body">
                            <h5 class="mb-2">{{ $paper->title }}</h5>
                            <p class="text-muted small mb-2"><i class="fas fa-users me-1"></i>{{ $paper->authors }}</p>
                            <p class="small">{{ Str::limit($paper->abstract, 180) }}</p>
                            @if($paper->keywords)
                                <div class="mt-auto">
                                    @foreach(explode(',', $paper->keywords) as $kw)
                                        <span class="badge-journal me-1">{{ trim($kw) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="info-box"><i class="fas fa-info-circle me-2 text-primary"></i>No papers published yet. Be the first to <a href="{{ route('register') }}">submit your research</a>!</div></div>
            @endforelse
        </div>
    </div>
</section>

<!-- Subject Areas Summary -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Subject Areas Covered</h2>
        <div class="row g-4">
            <div class="col-md-4 col-lg-2">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-cogs"></i></div>
                    <h6>Engineering &amp; Technology</h6>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-chart-line"></i></div>
                    <h6>Commerce &amp; Management</h6>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-users"></i></div>
                    <h6>Social Sciences</h6>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-gavel"></i></div>
                    <h6>Law &amp; Governance</h6>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-book"></i></div>
                    <h6>Humanities</h6>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card h-100 feature-card">
                    <div class="icon-wrap"><i class="fas fa-project-diagram"></i></div>
                    <h6>Interdisciplinary</h6>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('research-areas') }}" class="btn btn-outline-primary">View All Subject Areas <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

<!-- Latest News -->
@if($latestPosts->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Latest News &amp; Announcements</h2>
        <div class="row g-4">
            @foreach($latestPosts as $post)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5>{{ $post->title }}</h5>
                            <p class="small text-muted">{{ $post->created_at->format('M d, Y') }}</p>
                            <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                            <a href="{{ route('blog.show', $post) }}" class="small fw-semibold">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);">
    <div class="container text-center text-white">
        <h2 class="mb-3">Ready to Submit Your Research?</h2>
        <p class="mb-4 opacity-75">Join researchers from around the world publishing in SIJSEMSS.</p>
        <a href="{{ route('register') }}" class="btn btn-accent btn-lg"><i class="fas fa-paper-plane me-2"></i>Submit Your Manuscript</a>
    </div>
</section>
@endsection