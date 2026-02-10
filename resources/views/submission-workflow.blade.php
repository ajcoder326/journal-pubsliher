@extends('layouts.app')
@section('title', 'Submission & Review Workflow - SHARE IJ')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>Submission &amp; Review Workflow</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Submission Workflow</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <p class="lead mb-5">Our transparent, multi-step review workflow ensures academic rigor and quality at every stage of the publication process.</p>

            <div class="workflow-step">
                <div class="step-number">1</div>
                <h5>Manuscript Submission</h5>
                <p class="text-muted small">Authors submit their original manuscript through the journal's official submission system, ensuring compliance with the Author Guidelines, formatting requirements, and ethical standards.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">2</div>
                <h5>Preliminary Editorial Screening</h5>
                <p class="text-muted small mb-1">The Editorial Office conducts an initial screening to verify:</p>
                <ul class="small text-muted">
                    <li>Scope relevance</li>
                    <li>Compliance with submission guidelines</li>
                    <li>Completeness of manuscript details</li>
                </ul>
                <p class="small text-muted">Manuscripts failing to meet basic requirements are returned to authors for correction or desk rejection.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">3</div>
                <h5>Assignment to Reviewer</h5>
                <p class="text-muted small">The Editor-in-Chief / Managing Editor assigns the manuscript to a subject-specific reviewer based on disciplinary relevance and expertise.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">4</div>
                <h5>Peer Review</h5>
                <p class="text-muted small">The manuscript is sent to an independent reviewer under a blind peer review system, ensuring anonymity of the reviewer. Reviewers evaluate the manuscript on methodological rigor, clarity, relevance, and contribution to existing literature.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">5</div>
                <h5>Reviewer Recommendations</h5>
                <p class="text-muted small mb-1">Reviewers submit detailed reports with one of the following recommendations:</p>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <span class="badge bg-success">Accept without revision</span>
                    <span class="badge bg-warning text-dark">Accept with minor/major revisions</span>
                    <span class="badge bg-danger">Reject</span>
                </div>
            </div>

            <div class="workflow-step">
                <div class="step-number">6</div>
                <h5>Editorial Decision</h5>
                <p class="text-muted small">Based on reviewer feedback, the Editor communicates the decision to the author along with consolidated comments and required revisions, if any.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">7</div>
                <h5>Revision &amp; Re-Review (If Required)</h5>
                <p class="text-muted small">Authors revise the manuscript and submit a revised version along with a point-by-point response to reviewers' comments within the stipulated timeframe. Revised manuscripts may be sent back to reviewers or evaluated by the editor.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">8</div>
                <h5>Final Acceptance</h5>
                <p class="text-muted small">Upon successful revision and editorial approval, the manuscript is formally accepted for publication.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">9</div>
                <h5>Payment, Copyright &amp; Final Manuscript</h5>
                <p class="text-muted small">After acceptance, authors must complete the publication fee payment, submit the signed copyright form, and provide the final manuscript strictly in the prescribed journal format.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">10</div>
                <h5>Copyediting &amp; Proofreading</h5>
                <p class="text-muted small">The accepted manuscript undergoes copyediting and formatting to ensure clarity, consistency, and compliance with publication standards.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">11</div>
                <h5>Online Publication</h5>
                <p class="text-muted small">The final article is published under the journal's open access model, assigned publication details (DOI), and made available for global scholarly access.</p>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('register') }}" class="btn btn-accent btn-lg"><i class="fas fa-paper-plane me-2"></i>Start Your Submission</a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sidebar mb-4">
                <h5><i class="fas fa-clock me-2"></i>Timeline</h5>
                <table class="table table-sm table-borderless small mb-0">
                    <tr><td class="fw-semibold">Initial Screening</td><td>1&ndash;2 days</td></tr>
                    <tr><td class="fw-semibold">Peer Review</td><td>2&ndash;3 days</td></tr>
                    <tr><td class="fw-semibold">Revision Period</td><td>2&ndash;3 days</td></tr>
                    <tr><td class="fw-semibold">Final Decision</td><td>1&ndash;2 days</td></tr>
                    <tr><td class="fw-semibold">Publication</td><td>Within 2&ndash;3 days of acceptance</td></tr>
                </table>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-shield-alt me-2"></i>Review Standards</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Blind peer review</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Subject expert reviewers</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Plagiarism detection</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>UGC-aligned standards</li>
                    <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Transparent decisions</li>
                </ul>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-link me-2"></i>Related Pages</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><a href="{{ route('author-guidelines') }}"><i class="fas fa-file-alt me-2"></i>Author Guidelines</a></li>
                    <li class="mb-2"><a href="{{ route('apc') }}"><i class="fas fa-coins me-2"></i>Publication Charges</a></li>
                    <li class="mb-0"><a href="{{ route('call-for-papers') }}"><i class="fas fa-bullhorn me-2"></i>Call for Papers</a></li>
                </ul>
            </div>

            <div class="sidebar">
                <h5><i class="fas fa-envelope me-2"></i>Need Help?</h5>
                <p class="small mb-0">For queries: <a href="mailto:editor@shareij.org">editor@shareij.org</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
