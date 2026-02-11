@extends('layouts.app')

@section('title', 'About - SHARE IJ')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>About the Journal</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">About</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <p class="lead">Share International Journal of Sustainable Engineering, Management and Social Sciences (SHARE IJ) is a multidisciplinary, international, open access, scholarly, and peer-reviewed journal published by <strong>Share Study Hub</strong>, an academic publishing and research facilitation organization established as S.H.A.R.E. &ndash; "A Study Hub for Analysis, Research &amp; Evaluation."</p>

            <p>Guided by the core objective that <em>"Knowledge Shared is Knowledge Squared,"</em> the journal provides a global platform for researchers, academicians, and practitioners to disseminate original research, critical insights, and interdisciplinary perspectives that contribute to sustainable development, innovation, and societal progress.</p>

            <div class="info-box">
                <h5 class="mb-2"><i class="fas fa-history me-2 text-primary"></i>Our Legacy</h5>
                <p class="mb-2">Since its inception, Share Study Hub has been actively engaged in supporting academic research and publication across diverse disciplines. The publisher has contributed through its established print journals:</p>
                <ul class="mb-0">
                    <li><strong>Share Journal of Multidisciplinary Research and Studies</strong> &mdash; ISSN: 0976-4712 (Print) / Previous UGC Approved Journal No. 42613</li>
                    <li><strong>Journal of Multidisciplinary Research</strong> &mdash; ISSN: 2229-5003 (Print)</li>
                </ul>
            </div>

            <p>Building on this academic legacy, SHARE IJ is launched to address the growing need for rigorous, multidisciplinary, and sustainability-focused research. The journal aims to promote high-quality scholarly contributions that integrate engineering innovation, management practices, and social science perspectives, while adhering strictly to ethical publishing standards, peer-review integrity, open access principles, and UGC-aligned scholarly norms.</p>

            <h3 class="mt-5">Vision</h3>
            <p>Our vision is to be an internationally recognized multidisciplinary journal that promotes rigorous, ethical, and impactful research in sustainable engineering, management, and social sciences, contributing meaningfully to global knowledge creation and sustainable development.</p>

            <h3 class="mt-4">Mission</h3>
            <p>Our mission is to publish high-quality, peer-reviewed scholarly research through an open access model that ensures wide dissemination and academic visibility. The journal aims to foster interdisciplinary dialogue, support evidence-based research, and uphold academic integrity in accordance with UGC-aligned standards, ISSN norms, and globally accepted publication ethics.</p>

            <h3 class="mt-4">Aims &amp; Scope</h3>
            <p>The journal aims to advance theoretical, empirical, and applied research across the broad domains of sustainable engineering, management studies, and social sciences. It welcomes original research articles, review papers, conceptual studies, and case-based analyses that address sustainability, innovation, governance, organizational performance, socio-economic development, education, public policy, and emerging interdisciplinary themes.</p>
            <p>The scope emphasizes research that demonstrates methodological rigor, originality, and relevance to contemporary academic and societal issues, while encouraging cross-disciplinary perspectives and international research collaboration.</p>

            <h3 class="mt-5">Publication Ethics</h3>
            <p>The journal is committed to maintaining the highest standards of publication ethics and adheres to ethical guidelines consistent with UGC norms, ISSN requirements, and internationally accepted scholarly publishing practices. Authors must ensure that submitted manuscripts are original, properly cited, and free from plagiarism, data fabrication, or falsification. The journal uses plagiarism detection tools to verify originality.</p>

            <h3 class="mt-4">Open Access Policy</h3>
            <p>SHARE IJ is an open access journal, providing immediate and unrestricted access to published content. This model supports the free exchange of knowledge, enhances research visibility, and promotes wider academic and societal impact without financial or institutional barriers.</p>

            <h3 class="mt-4">Peer Review Policy</h3>
            <p>The journal follows a <strong>blind peer review</strong> process to ensure impartiality, academic rigor, and transparency in the evaluation of manuscripts. Each submission is reviewed by subject experts based on originality, relevance, research design, ethical compliance, and contribution to existing literature.</p>

            <h3 class="mt-4">UGC &amp; ISSN Compliance</h3>
            <p>All published content is archived and documented in alignment with UGC-oriented quality benchmarks and international scholarly publishing norms. The journal adheres to ISSN guidelines and follows standardized editorial and publication practices to ensure consistency, transparency, and long-term academic credibility.</p>
        </div>

        <div class="col-lg-4">
            <div class="sidebar mb-4">
                <h5><i class="fas fa-list-check me-2"></i>Journal at a Glance</h5>
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="fw-semibold">Publisher</td><td>Share Study Hub</td></tr>
                    <tr><td class="fw-semibold">Established</td><td>2026</td></tr>
                    <tr><td class="fw-semibold">Frequency</td><td>Monthly e-Journal</td></tr>
                    <tr><td class="fw-semibold">Language</td><td>English & Hindi</td></tr>
                    <tr><td class="fw-semibold">ISSN</td><td>Applied</td></tr>
                    <tr><td class="fw-semibold">Access</td><td>Open Access</td></tr>
                    <tr><td class="fw-semibold">Peer Review</td><td>Blind</td></tr>
                    <tr><td class="fw-semibold">Country</td><td>India</td></tr>
                    <tr><td class="fw-semibold">Mode</td><td>Online</td></tr>
                </table>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-file-alt me-2"></i>Manuscripts Accepted</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Original Research Articles</li>
                    <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Review Papers</li>
                    <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Conceptual Papers</li>
                    <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Case Studies</li>
                    <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Empirical Studies</li>
                </ul>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-star me-2"></i>Why Publish Here?</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Previous UGC Approved</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>DOI for all articles</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Rapid peer review</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Instant certification</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Comprehensive indexing</li>
                    <li class="mb-0"><i class="fas fa-check-circle text-primary me-2"></i>Author support provided</li>
                </ul>
            </div>

            <div class="card text-center" style="background: linear-gradient(135deg, var(--primary), var(--accent)); border:none;">
                <div class="card-body text-white py-4">
                    <h5 class="mb-3">Submit Your Research</h5>
                    <a href="{{ route('register') }}" class="btn btn-accent"><i class="fas fa-paper-plane me-1"></i>Submit Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
