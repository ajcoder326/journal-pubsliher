@extends('layouts.app')
@section('title', 'Volumes - SHARE IJ')
@section('content')
<div class="container py-5">
    <h1 class="section-title">Journal Archive</h1>
    <div class="row">
        @forelse($volumes as $volume)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="bg-primary text-white p-3 rounded me-3 text-center" style="min-width: 80px;">
                                <h4 class="mb-0">Vol.</h4>
                                <h3 class="mb-0">{{ $volume->issue_number }}</h3>
                            </div>
                            <div>
                                <h5>{{ $volume->title }}</h5>
                                <p class="text-muted mb-1">{{ $volume->year }}</p>
                                <p class="small">{{ Str::limit($volume->description, 100) }}</p>
                                <a href="{{ route('volumes.show', $volume) }}" class="btn btn-sm btn-outline-primary">View Papers</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No volumes published yet.</div>
            </div>
        @endforelse
    </div>
    {{ $volumes->links() }}
</div>
@endsection
