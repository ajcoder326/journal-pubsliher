@extends('layouts.admin')
@section('title', 'Reviews')
@section('page-title', 'Manage Reviews')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paper</th>
                        <th>Reviewer</th>
                        <th>Recommendation</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
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
                            <td>{{ $review->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this review?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No reviews found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $reviews->links() }}
    </div>
</div>
@endsection
