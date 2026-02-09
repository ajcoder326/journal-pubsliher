@extends('layouts.app')
@section('title', 'Article Processing Charges - SIJSEMSS')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>Article Processing Charges (APC)</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Publication Charges</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <p class="lead">Share International Journal of Sustainable Engineering, Management and Social Sciences follows a transparent, ethical, and author-friendly publication policy.</p>

            <div class="info-box">
                <i class="fas fa-info-circle text-primary me-2"></i>The journal does <strong>not levy any fee</strong> for manuscript submission or peer review. Article Processing Charges (APC) are collected <strong>only after formal acceptance</strong> of the manuscript.
            </div>

            <h3 class="mt-4">What APC Covers</h3>
            <p>The APC supports essential publication and dissemination services, including:</p>
            <div class="row mb-4">
                <div class="col-md-6">
                    <ul class="small">
                        <li>Editorial and technical processing</li>
                        <li>Peer-review coordination</li>
                        <li>Plagiarism screening</li>
                        <li>Copyediting and formatting</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="small">
                        <li>DOI assignment</li>
                        <li>Open-access online publication</li>
                        <li>Long-term digital archiving</li>
                        <li>Individual Certificate of Publication</li>
                    </ul>
                </div>
            </div>

            <h3 class="mt-4">Fee Structure</h3>
            <table class="table table-bordered">
                <thead>
                    <tr class="apc-table"><th>Fee Type</th><th>Amount</th></tr>
                </thead>
                <tbody>
                    <tr><td>Submission Fee</td><td><strong class="text-success">Nil</strong></td></tr>
                    <tr><td>Peer Review Fee</td><td><strong class="text-success">Nil</strong></td></tr>
                    <tr class="table-light"><td colspan="2"><strong>Article Processing Charges (payable only after acceptance):</strong></td></tr>
                    <tr><td>Indian Authors</td><td><strong>&#8377;999</strong> (Upto 3 Authors, Additional &#8377;250 per author)</td></tr>
                    <tr><td>Foreign Authors</td><td><strong>USD 40</strong> (Upto 3 Authors, Additional USD 10 per author)</td></tr>
                </tbody>
            </table>

            <div class="alert alert-warning border-0 mt-4">
                <i class="fas fa-exclamation-triangle me-2"></i><strong>Important:</strong> The payment of APC has <strong>no influence</strong> on editorial or peer-review decisions, which are based solely on academic merit, originality, and relevance.
            </div>

            <p class="small">Details regarding APC, including any waivers or concessions for students or authors from economically disadvantaged backgrounds, are communicated transparently to authors at the time of acceptance.</p>

            <h3 class="mt-5">Refund Policy</h3>
            <p>APC once paid is generally non-refundable, as editorial and publication processing activities begin immediately after payment confirmation.</p>

            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <div class="card h-100 border-danger">
                        <div class="card-header bg-danger text-white"><i class="fas fa-times-circle me-2"></i>Non-Refundable Conditions</div>
                        <div class="card-body">
                            <ul class="small mb-0">
                                <li>Withdrawal by author after acceptance</li>
                                <li>Rejection due to plagiarism or ethical misconduct</li>
                                <li>Delay caused by incomplete author documentation</li>
                                <li>Author dissatisfaction after publication</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-success">
                        <div class="card-header bg-success text-white"><i class="fas fa-check-circle me-2"></i>Refundable Conditions</div>
                        <div class="card-body">
                            <ul class="small mb-0">
                                <li>Duplicate payment made by author</li>
                                <li>Payment due to technical/administrative error</li>
                                <li>Withdrawal by journal before publication for editorial reasons</li>
                            </ul>
                            <p class="small text-muted mt-2 mb-0">Eligible refunds processed within a reasonable timeframe after verification.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 mb-4" style="background: linear-gradient(135deg, var(--primary), var(--accent)); color:#fff;">
                <div class="card-body py-4 text-center">
                    <h4>APC Summary</h4>
                    <hr style="border-color:rgba(255,255,255,0.3);">
                    <div class="mb-3">
                        <div class="small opacity-75">Indian Authors</div>
                        <div class="display-6 fw-bold">&#8377;999</div>
                        <div class="small opacity-75">Upto 3 authors</div>
                    </div>
                    <div class="mb-3">
                        <div class="small opacity-75">Foreign Authors</div>
                        <div class="display-6 fw-bold">$40</div>
                        <div class="small opacity-75">Upto 3 authors</div>
                    </div>
                    <hr style="border-color:rgba(255,255,255,0.3);">
                    <div class="small">
                        <i class="fas fa-check-circle me-1"></i>No Submission Fee<br>
                        <i class="fas fa-check-circle me-1"></i>No Review Fee
                    </div>
                </div>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-gift me-2"></i>APC Includes</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Open-access publication</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>DOI assignment</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Plagiarism checking</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Certificate for all authors</li>
                    <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Long-term digital preservation</li>
                </ul>
            </div>

            <div class="sidebar">
                <h5><i class="fas fa-envelope me-2"></i>Questions?</h5>
                <p class="small mb-0">Contact: <a href="mailto:editor@shareij.org">editor@shareij.org</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
