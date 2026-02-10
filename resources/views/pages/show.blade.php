@extends('layouts.app')

@section('title', ($page->meta_title ?: $page->title) . ' - SHARE IJ')

@if($page->meta_description)
@section('meta_description', $page->meta_description)
@endif

@section('content')
<div class="page-header">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body p-4 p-md-5">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
