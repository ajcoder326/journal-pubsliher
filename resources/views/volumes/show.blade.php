@extends('layouts.app')
@section('title', $volume->title . ' - SIJSEMSS')
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('volumes.index') }}">Volumes</a></li>
            <li class="breadcrumb-item active">Vol. {{ $volume->issue_number }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-lg-8">
            <h1>{{ $volume->title }}</h1>
            <p class="text-muted">Volume {{ $volume->issue_number }}, {{ $volume->year }}</p>
            <p>{{ $volume->description }}</p>
            
            <h3 class="mt-4 section-title">Papers in this Volume</h3>
            @forelse($volume->papers as $paper)
                <div class="card paper-card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('papers.show', $paper) }}">{{ $paper->title }}</a>
                        </h5>
                        <p class="text-muted small mb-2"><i class="fas fa-users me-1"></i> {{ $paper->authors }}</p>
                        <p class="card-text">{{ Str::limit($paper->abstract, 200) }}</p>
                        <a href="{{ route('papers.show', $paper) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                        <a href="{{ route('papers.download', $paper) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download me-1"></i>Download</a>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">No papers in this volume yet.</div>
            @endforelse
        </div>
        <div class="col-lg-4">
            <div class="sidebar">
                <h5>Volume Details</h5>
                <p><strong>Volume:</strong> {{ $volume->issue_number }}</p>
                <p><strong>Year:</strong> {{ $volume->year }}</p>
                <p><strong>Papers:</strong> {{ $volume->papers->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
