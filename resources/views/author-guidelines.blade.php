@extends('layouts.app')
@section('title', 'Author Guidelines - SIJSEMSS')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>Author Guidelines</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Author Guidelines</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <p class="lead">Authors are invited to submit original, unpublished manuscripts that are not under consideration for publication elsewhere. Submissions should contribute meaningfully to theory, practice, or policy in the areas of sustainable engineering, management, and social sciences.</p>

            <h3 class="mt-5">Manuscript Preparation</h3>
            <div class="info-box">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="small mb-0">
                            <li><strong>Language:</strong> English and Hindi</li>
                            <li><strong>Format:</strong> MS Word (.doc/.docx)</li>
                            <li><strong>Page Size:</strong> A4 only</li>
                            <li><strong>Font:</strong> Times New Roman throughout</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="small mb-0">
                            <li><strong>Text Column:</strong> Single, justified</li>
                            <li><strong>Title:</strong> 24pt, Times New Roman, center</li>
                            <li><strong>Line Spacing:</strong> Single</li>
                            <li><strong>Paragraph Indent:</strong> 0.2"</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h5 class="mt-4">Page Margins</h5>
            <p>Left &ndash; 0.51" | Right &ndash; 0.51" | Top &ndash; 0.75" | Bottom &ndash; 0.75" | Header 0.3" | Footer 0"</p>

            <h5 class="mt-4">Manuscript Length</h5>
            <ul>
                <li>Research Articles and Review Papers: <strong>3,000&ndash;6,000 words</strong></li>
                <li>Case Studies / Conceptual Papers: <strong>2,000&ndash;4,000 words</strong></li>
            </ul>

            <h3 class="mt-5">Structure of the Manuscript</h3>
            <ol>
                <li><strong>Title Page</strong> (title, author name(s), affiliation(s), email ID, mobile)</li>
                <li><strong>Abstract</strong> (200&ndash;250 words)</li>
                <li><strong>Keywords</strong> (3&ndash;6)</li>
                <li><strong>Introduction</strong></li>
                <li><strong>Review of Literature</strong></li>
                <li><strong>Research Methodology</strong> (if applicable)</li>
                <li><strong>Data Analysis / Results</strong></li>
                <li><strong>Discussion</strong></li>
                <li><strong>Conclusion and Implications</strong></li>
                <li><strong>References</strong></li>
                <li><strong>Appendices</strong> (if any)</li>
            </ol>

            <h3 class="mt-5">Formatting Details</h3>
            <table class="table table-bordered small">
                <thead class="table-light">
                    <tr><th>Element</th><th>Specification</th></tr>
                </thead>
                <tbody>
                    <tr><td>Paper Title</td><td>18pt, Times New Roman, UPPER CASE, Center aligned. Line spacing: Before 8pt, After 16pt</td></tr>
                    <tr><td>Subtitle</td><td>14pt, Italic. Line spacing: Before 8pt, After 16pt</td></tr>
                    <tr><td>Author Names</td><td>Numbered with superscripts. Include designation, department, organization, city, country.</td></tr>
                    <tr><td>Figure Caption</td><td>10pt, lowercase, below the figure, center aligned</td></tr>
                    <tr><td>Table Caption</td><td>10pt, lowercase, top of the table, center aligned</td></tr>
                </tbody>
            </table>

            <h3 class="mt-5">Referencing Style</h3>
            <p>Authors must follow the <strong>APA (7th edition)</strong> referencing style consistently throughout the manuscript for all in-text citations and references. Manuscripts not conforming to APA (7th edition) may be returned for revision.</p>
            <div class="info-box">
                <h6>Examples:</h6>
                <ul class="small mb-0">
                    <li><strong>In-text citation:</strong> (Porter, 2019)</li>
                    <li><strong>Book:</strong> Porter, M. E. (2019). <em>Competitive strategy</em>. Free Press.</li>
                    <li><strong>Journal article:</strong> Porter, M. E. (2019). Competitive strategy and firm performance. <em>Strategic Management Journal, 40</em>(2), 215&ndash;238. https://doi.org/xx.xxxx/xxxx</li>
                </ul>
            </div>

            <h3 class="mt-5">Ethical &amp; Plagiarism Policy</h3>
            <ul>
                <li>Manuscripts must be <strong>original and plagiarism-free</strong>.</li>
                <li>Similarity index should not exceed <strong>15%</strong>, excluding references, as per UGC-aligned best practices.</li>
                <li>Proper acknowledgment of all sources is mandatory.</li>
                <li>Any form of unethical practice may result in rejection or retraction.</li>
            </ul>

            <h3 class="mt-5">Submission Process</h3>
            <ol>
                <li>Create an account or login to the journal portal.</li>
                <li>Submit your manuscript in Word format (.doc/.docx) with all required details.</li>
                <li>Track your submission status from your dashboard.</li>
                <li>Respond to reviewer feedback within the stipulated timeframe.</li>
            </ol>

            <div class="text-center mt-5">
                <a href="{{ route('register') }}" class="btn btn-accent btn-lg"><i class="fas fa-paper-plane me-2"></i>Submit Your Manuscript</a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sidebar mb-4">
                <h5><i class="fas fa-list-check me-2"></i>Quick Checklist</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><input type="checkbox" disabled> Original, unpublished work</li>
                    <li class="mb-2"><input type="checkbox" disabled> MS Word format (.doc/.docx)</li>
                    <li class="mb-2"><input type="checkbox" disabled> A4 page size</li>
                    <li class="mb-2"><input type="checkbox" disabled> Times New Roman font</li>
                    <li class="mb-2"><input type="checkbox" disabled> Abstract (200&ndash;250 words)</li>
                    <li class="mb-2"><input type="checkbox" disabled> 3&ndash;6 keywords</li>
                    <li class="mb-2"><input type="checkbox" disabled> APA 7th edition referencing</li>
                    <li class="mb-2"><input type="checkbox" disabled> Plagiarism &le; 15%</li>
                    <li class="mb-0"><input type="checkbox" disabled> All author details provided</li>
                </ul>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-link me-2"></i>Quick Links</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><a href="{{ route('call-for-papers') }}"><i class="fas fa-bullhorn me-2"></i>Call for Papers</a></li>
                    <li class="mb-2"><a href="{{ route('submission-workflow') }}"><i class="fas fa-tasks me-2"></i>Submission Workflow</a></li>
                    <li class="mb-2"><a href="{{ route('apc') }}"><i class="fas fa-coins me-2"></i>Publication Charges</a></li>
                    <li class="mb-0"><a href="{{ route('research-areas') }}"><i class="fas fa-microscope me-2"></i>Subject Areas</a></li>
                </ul>
            </div>

            <div class="sidebar">
                <h5><i class="fas fa-envelope me-2"></i>Need Help?</h5>
                <p class="small mb-0">For submission queries, contact: <a href="mailto:editor@shareij.org">editor@shareij.org</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
