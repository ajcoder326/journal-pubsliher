@extends('layouts.app')
@section('title', 'Call for Papers - SIJSEMSS')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>Call for Papers</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Call for Papers</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <p class="lead">Share International Journal of Sustainable Engineering, Management and Social Sciences invites original, unpublished research papers for its forthcoming issue(s).</p>

            <p>The journal welcomes high-quality empirical, theoretical, review, and case-based studies across a wide range of multidisciplinary subject areas. Submissions should contribute meaningfully to knowledge creation, policy discourse, and professional practice at national and international levels.</p>

            <p>All manuscripts are subjected to a rigorous peer-review process and published under an open-access model. Submissions must strictly comply with the journal's <a href="{{ route('author-guidelines') }}">author guidelines</a> and publication ethics.</p>

            <div class="alert alert-info border-0" style="background:rgba(26,115,232,0.08);">
                <i class="fas fa-users me-2 text-primary"></i><strong>Researchers, academicians, practitioners, and doctoral scholars</strong> are encouraged to submit their original work.
            </div>

            <h3 class="mt-5">Subject Areas Covered</h3>

            <div class="accordion mt-3" id="subjectAreas">
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#area1"><i class="fas fa-cogs me-2"></i>Engineering &amp; Technology</button></h2>
                    <div id="area1" class="accordion-collapse collapse show" data-bs-parent="#subjectAreas">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6"><ul class="small mb-0">
                                    <li>Civil Engineering</li><li>Mechanical Engineering</li><li>Electrical Engineering</li><li>Electronics & Communication</li><li>Computer Science & Engineering</li><li>Information Technology</li><li>AI and Data Science</li>
                                </ul></div>
                                <div class="col-md-6"><ul class="small mb-0">
                                    <li>Environmental Engineering</li><li>Industrial & Production Engineering</li><li>Chemical Engineering</li><li>Biotechnology & Biomedical Engineering</li><li>Renewable Energy & Sustainable Engineering</li><li>Smart Systems, IoT & Emerging Technologies</li>
                                </ul></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#area2"><i class="fas fa-chart-line me-2"></i>Commerce &amp; Management</button></h2>
                    <div id="area2" class="accordion-collapse collapse" data-bs-parent="#subjectAreas">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6"><ul class="small mb-0">
                                    <li>Business Administration</li><li>Commerce & Accounting</li><li>Finance & Banking</li><li>Marketing Management</li><li>Human Resource Management</li><li>Operations & Supply Chain</li>
                                </ul></div>
                                <div class="col-md-6"><ul class="small mb-0">
                                    <li>Strategic Management</li><li>Entrepreneurship & Innovation</li><li>International Business</li><li>Corporate Governance & Ethics</li><li>Economics & Managerial Economics</li><li>Sustainability & ESG Studies</li>
                                </ul></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#area3"><i class="fas fa-users me-2"></i>Social Sciences</button></h2>
                    <div id="area3" class="accordion-collapse collapse" data-bs-parent="#subjectAreas">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6"><ul class="small mb-0">
                                    <li>Economics & Development Studies</li><li>Sociology</li><li>Political Science</li><li>Public Administration</li><li>Education & Educational Management</li><li>Psychology & Behavioral Studies</li>
                                </ul></div>
                                <div class="col-md-6"><ul class="small mb-0">
                                    <li>Social Work</li><li>Gender Studies & Women Studies</li><li>Demography & Population Studies</li><li>Rural and Urban Studies</li><li>Work-Life Balance & Employee Well-Being</li>
                                </ul></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#area4"><i class="fas fa-gavel me-2"></i>Law &amp; Governance</button></h2>
                    <div id="area4" class="accordion-collapse collapse" data-bs-parent="#subjectAreas">
                        <div class="accordion-body"><ul class="small mb-0">
                            <li>Constitutional Law</li><li>Corporate & Commercial Law</li><li>Environmental & Sustainability Law</li><li>Labour & Industrial Law</li><li>Human Rights & Social Justice</li><li>International Law</li><li>Public Policy & Regulatory Studies</li><li>Governance, Ethics & Compliance</li>
                        </ul></div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#area5"><i class="fas fa-book me-2"></i>Humanities</button></h2>
                    <div id="area5" class="accordion-collapse collapse" data-bs-parent="#subjectAreas">
                        <div class="accordion-body"><ul class="small mb-0">
                            <li>English Literature & Language Studies</li><li>History & Cultural Studies</li><li>Philosophy & Ethics</li><li>Media & Communication Studies</li><li>Journalism & Mass Communication</li><li>Linguistics</li><li>Heritage & Cultural Sustainability</li>
                        </ul></div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#area6"><i class="fas fa-project-diagram me-2"></i>Interdisciplinary &amp; Other Areas</button></h2>
                    <div id="area6" class="accordion-collapse collapse" data-bs-parent="#subjectAreas">
                        <div class="accordion-body"><ul class="small mb-0">
                            <li>Sustainable Development Studies</li><li>Environmental Studies</li><li>Climate Change & Policy Studies</li><li>Digital Society & Technology Studies</li><li>Research Methodology & Applied Statistics</li><li>Data Analytics & Decision Sciences</li><li>Multidisciplinary & Interdisciplinary Research</li>
                        </ul></div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('register') }}" class="btn btn-accent btn-lg"><i class="fas fa-paper-plane me-2"></i>Submit Your Manuscript</a>
                <a href="{{ route('author-guidelines') }}" class="btn btn-outline-primary btn-lg ms-2"><i class="fas fa-file-alt me-2"></i>Author Guidelines</a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 mb-4" style="background: linear-gradient(135deg, var(--primary), var(--accent)); color:#fff;">
                <div class="card-body py-4">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Important Information</h5>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><i class="fas fa-clock me-2"></i><strong>Submission:</strong> Rolling basis (always open)</li>
                        <li class="mb-2"><i class="fas fa-search me-2"></i><strong>Review Period:</strong> 2&ndash;4 weeks</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i><strong>Publication:</strong> Upon acceptance</li>
                        <li class="mb-2"><i class="fas fa-calendar me-2"></i><strong>Frequency:</strong> Monthly</li>
                        <li class="mb-0"><i class="fas fa-coins me-2"></i><strong>Indian APC:</strong> &#8377;999 | <strong>Foreign:</strong> $40</li>
                    </ul>
                </div>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-question-circle me-2"></i>Submission Checklist</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Original, unpublished manuscript</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>MS Word format (.doc/.docx)</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>APA 7th edition referencing</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Plagiarism &le; 15%</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Abstract 200&ndash;250 words</li>
                    <li class="mb-0"><i class="fas fa-check text-success me-2"></i>3&ndash;6 keywords</li>
                </ul>
            </div>

            <div class="sidebar">
                <h5><i class="fas fa-envelope me-2"></i>Contact Editor</h5>
                <p class="small mb-0">For queries: <a href="mailto:editor@shareij.org">editor@shareij.org</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
