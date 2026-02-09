@extends('layouts.app')
@section('title', 'Contact - SIJSEMSS')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Contact</li></ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="mb-4">Send Us a Message</h4>
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i>Send Message</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="sidebar mb-4">
                <h5><i class="fas fa-address-card me-2"></i>Contact Information</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <strong>Email:</strong><br>
                        <a href="mailto:editor@shareij.org">editor@shareij.org</a>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-building text-primary me-2"></i>
                        <strong>Publisher:</strong><br>
                        Share Study Hub<br>
                        <small class="text-muted">Est. 2010 &ndash; "A Study Hub for Analysis, Research & Evaluation"</small>
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <strong>Country:</strong> India
                    </li>
                </ul>
            </div>

            <div class="sidebar mb-4">
                <h5><i class="fas fa-clock me-2"></i>Response Time</h5>
                <p class="small mb-0">We aim to respond to all queries within <strong>24&ndash;48 hours</strong> on working days.</p>
            </div>

            <div class="sidebar">
                <h5><i class="fas fa-question-circle me-2"></i>Common Queries</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><a href="{{ route('author-guidelines') }}">How to submit a paper?</a></li>
                    <li class="mb-2"><a href="{{ route('apc') }}">What are the publication charges?</a></li>
                    <li class="mb-2"><a href="{{ route('submission-workflow') }}">What is the review process?</a></li>
                    <li class="mb-0"><a href="{{ route('call-for-papers') }}">What subjects are covered?</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
