@extends('layouts.app')

@section('title', $paper->title . ' - SHARE IJ')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('volumes.index') }}">Volumes</a></li>
                    @if($paper->volume)
                        <li class="breadcrumb-item"><a href="{{ route('volumes.show', $paper->volume) }}">{{ $paper->volume->title }}</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ Str::limit($paper->title, 30) }}</li>
                </ol>
            </nav>

            <article>
                <h1 class="h2 mb-3">{{ $paper->title }}</h1>
                
                <div class="text-muted mb-4">
                    <p class="mb-1"><strong>Authors:</strong> {{ $paper->authors }}</p>
                    @if($paper->keywords)
                        <p class="mb-1"><strong>Keywords:</strong> {{ $paper->keywords }}</p>
                    @endif
                    <p class="mb-1"><strong>Published:</strong> {{ $paper->created_at->format('F d, Y') }}</p>
                    @if($paper->volume)
                        <p class="mb-1"><strong>Volume:</strong> {{ $paper->volume->title }}</p>
                    @endif
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Abstract</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="text-align: justify;">{{ $paper->abstract }}</p>
                    </div>
                </div>

                @if($paper->document_path)
                    <div class="d-flex gap-2">
                        <a href="{{ route('papers.download', $paper) }}" class="btn btn-primary">
                            <i class="fas fa-download me-2"></i>Download PDF
                        </a>
                        <a href="{{ asset('storage/' . $paper->document_path) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>View PDF
                        </a>
                    </div>
                @endif
            </article>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Paper Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-calendar me-2 text-muted"></i>
                            <strong>Published:</strong><br>
                            <span class="ms-4">{{ $paper->created_at->format('F d, Y') }}</span>
                        </li>
                        @if($paper->volume)
                            <li class="mb-2">
                                <i class="fas fa-book me-2 text-muted"></i>
                                <strong>Volume:</strong><br>
                                <a href="{{ route('volumes.show', $paper->volume) }}" class="ms-4">{{ $paper->volume->title }}</a>
                            </li>
                        @endif
                        <li class="mb-2">
                            <i class="fas fa-users me-2 text-muted"></i>
                            <strong>Authors:</strong><br>
                            <span class="ms-4">{{ $paper->authors }}</span>
                        </li>
                        @if($paper->keywords)
                            <li class="mb-0">
                                <i class="fas fa-tags me-2 text-muted"></i>
                                <strong>Keywords:</strong><br>
                                <span class="ms-4">{{ $paper->keywords }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if($paper->volume && $paper->volume->papers->where('id', '!=', $paper->id)->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Other Papers in This Volume</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($paper->volume->papers->where('id', '!=', $paper->id)->take(5) as $otherPaper)
                            <li class="list-group-item">
                                <a href="{{ route('papers.show', $otherPaper) }}">{{ Str::limit($otherPaper->title, 50) }}</a>
                                <br><small class="text-muted">{{ $otherPaper->authors }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection