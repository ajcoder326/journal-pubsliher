@extends('layouts.app')
@section('title', 'Editorial Board - SIJSEMSS')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>Editorial Board</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Editorial Board</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <!-- Editor-in-Chief -->
    <h2 class="section-title">Editor-in-Chief</h2>
    <div class="row mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px;">
                            <i class="fas fa-user-tie text-white" style="font-size:2rem;"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">Dr. Surendra Sisodia</h5>
                    <span class="badge bg-warning text-dark mb-2">Editor-in-Chief</span>
                    <p class="small text-muted mb-0">Jaipur, Rajasthan, India</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Editorial Board Members -->
    <h2 class="section-title">Editorial Board Members</h2>
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                            <i class="fas fa-user text-white" style="font-size:1.5rem;"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">Prof (Dr). Pragya Tank</h5>
                    <span class="badge bg-secondary mb-2">Editorial Board</span>
                    <p class="small text-muted mb-0">Ajmer, Rajasthan, India</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                            <i class="fas fa-user text-white" style="font-size:1.5rem;"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">Prof (Dr). Hanuman Prasad</h5>
                    <span class="badge bg-secondary mb-2">Editorial Board</span>
                    <p class="small text-muted mb-0">Mohan Lal Sukhadia University, Udaipur, Rajasthan, India</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                            <i class="fas fa-user text-white" style="font-size:1.5rem;"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">Prof (Dr). Sanjay Bayani</h5>
                    <span class="badge bg-secondary mb-2">Editorial Board</span>
                    <p class="small text-muted mb-0">Saurashtra University, Rajkot, Gujarat, India</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                            <i class="fas fa-user text-white" style="font-size:1.5rem;"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">Prof (Dr). K A S Dhammika</h5>
                    <span class="badge bg-secondary mb-2">Editorial Board</span>
                    <p class="small text-muted mb-0">University of Kelaniya, Sri Lanka</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic board from DB -->
    @if($editors->count() > 0)
    <h2 class="section-title">Additional Board Members</h2>
    <div class="row g-4 mb-5">
        @foreach($editors as $editor)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            @if($editor->avatar)
                                <img src="{{ asset('storage/' . $editor->avatar) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                                    <i class="fas fa-user text-white" style="font-size:1.5rem;"></i>
                                </div>
                            @endif
                        </div>
                        <h5 class="card-title mb-1">{{ $editor->name }}</h5>
                        <span class="badge bg-secondary mb-2">{{ ucwords(str_replace('_', ' ', $editor->role)) }}</span>
                        @if($editor->affiliation)
                            <p class="small text-muted mb-0">{{ $editor->affiliation }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <!-- Join Section -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100" style="border-left: 4px solid var(--secondary);">
                <div class="card-body">
                    <h4><i class="fas fa-clipboard-check me-2 text-primary"></i>Join as a Reviewer</h4>
                    <p>Experienced academicians, researchers, and professionals are invited to join the reviewer panel.</p>
                    <h6>Eligibility:</h6>
                    <ul class="small">
                        <li>Doctoral degree or equivalent experience</li>
                        <li>Active involvement in research or teaching</li>
                        <li>At least two publications in peer-reviewed journals</li>
                        <li>Commitment to ethical and unbiased review</li>
                    </ul>
                    <h6>Benefits:</h6>
                    <ul class="small">
                        <li>Academic recognition as a reviewer of an international journal</li>
                        <li>Certificate of reviewing contribution</li>
                        <li>Engagement with interdisciplinary research</li>
                    </ul>
                    <p class="small mb-0"><strong>Apply:</strong> Send CV to <a href="mailto:editor@shareij.org">editor@shareij.org</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100" style="border-left: 4px solid var(--accent);">
                <div class="card-body">
                    <h4><i class="fas fa-users-cog me-2 text-primary"></i>Join the Editorial Team</h4>
                    <p>Qualified academicians are invited to join as Associate Editor, Assistant Editor, Co-Editor, or other positions.</p>
                    <h6>Eligibility:</h6>
                    <ul class="small">
                        <li>Ph.D. or equivalent qualification in a relevant discipline</li>
                        <li>Strong research and publication record</li>
                        <li>Prior experience in peer review or editorial roles (preferred)</li>
                        <li>Demonstrated academic integrity and leadership</li>
                    </ul>
                    <h6>Benefits:</h6>
                    <ul class="small">
                        <li>Formal recognition on the journal website</li>
                        <li>Active role in shaping the journal's academic direction</li>
                        <li>Professional engagement with international researchers</li>
                    </ul>
                    <p class="small mb-0"><strong>Apply:</strong> Send CV to <a href="mailto:editor@shareij.org">editor@shareij.org</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
