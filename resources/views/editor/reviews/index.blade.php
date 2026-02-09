@extends('layouts.editor')
@section('title', 'Reviews')
@section('content')
<h2 class="mb-4">All Reviews</h2>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Paper</th>
                    <th>Reviewer</th>
                    <th>Recommendation</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ Str::limit($review->paper->title ?? 'N/A', 35) }}</td>
                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                    <td>
                        @if($review->recommendation)
                        <span class="badge bg-{{ $review->recommendation == 'accept' ? 'success' : ($review->recommendation == 'reject' ? 'danger' : 'warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                        </span>
                        @else
                        <span class="badge bg-secondary">Pending</span>
                        @endif
                    </td>
                    <td>{{ $review->updated_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">No reviews found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection