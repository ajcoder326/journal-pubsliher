@extends('layouts.app')
@section('title', 'Review Paper')
@section('content')
<div class="container py-5">
    <h2>Review Paper</h2>
    <div class="card mb-4">
        <div class="card-header"><strong>Paper Details</strong></div>
        <div class="card-body">
            <h5>{{ $review->paper->title ?? 'N/A' }}</h5>
            <p><strong>Authors:</strong> {{ $review->paper->authors ?? 'N/A' }}</p>
            <p><strong>Abstract:</strong></p>
            <p>{{ $review->paper->abstract ?? 'N/A' }}</p>
        </div>
    </div>
    @if(!$review->recommendation)
    <div class="card">
        <div class="card-header"><strong>Submit Review</strong></div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.reviews.store', $review->paper) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Reviewer Comment *</label>
                    <select name="comment_preset" id="comment_preset" class="form-select" required>
                        <option value="">Select a comment...</option>
                        <option value="comment_1">Reviewer Comment 1</option>
                        <option value="comment_2">Reviewer Comment 2</option>
                        <option value="comment_3">Reviewer Comment 3</option>
                        <option value="comment_4">Reviewer Comment 4</option>
                        <option value="other">Other Comments / Suggestions</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Recommendation *</label>
                    <select name="recommendation" class="form-select" required>
                        <option value="">Select...</option>
                        <option value="accept">Accept</option>
                        <option value="minor_revision">Minor Revision</option>
                        <option value="major_revision">Major Revision</option>
                        <option value="reject">Reject</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Comments for Authors *</label>
                    <textarea name="comments" id="comments" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3 d-none" id="other_comments_wrap">
                    <label class="form-label">Other Comments / Suggestions *</label>
                    <textarea name="other_comments" id="other_comments" class="form-control" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confidential Comments for Editor</label>
                    <textarea name="confidential_comments" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-header"><strong>Your Review</strong></div>
        <div class="card-body">
            <p><strong>Recommendation:</strong> {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}</p>
            <p><strong>Comments:</strong> {{ $review->comments }}</p>
            <p class="text-muted">Submitted on {{ $review->updated_at->format('M d, Y') }}</p>
        </div>
    </div>
    @endif
    <a href="{{ route('dashboard.reviews.index') }}" class="btn btn-secondary mt-3">Back to Reviews</a>
</div>
<script>
const commentMap = {
    comment_1: 'The manuscript addresses a relevant topic within the journal\'s scope. The objectives, methodology, and findings are presented in a reasonably clear manner. The overall presentation is coherent and follows academic conventions. After evaluation, the paper may be considered for publication.',
    comment_2: 'The study is adequately structured and the research approach is appropriate to the stated objectives. The analysis supports the conclusions drawn. The references used are generally relevant to the topic. The manuscript is suitable to proceed for publication.',
    comment_3: 'The paper demonstrates acceptable academic standards in terms of organization, methodology, and presentation. The arguments are coherent and supported by the data provided. The discussion aligns with the stated research objectives. It may be accepted for publication.',
    comment_4: 'The manuscript has been reviewed from methodological, structural, and relevance perspectives. It meets the required academic and publication standards. The content is appropriately organized and clearly presented. The paper can be approved for publication.'
};

const presetSelect = document.getElementById('comment_preset');
const commentsField = document.getElementById('comments');
const otherWrap = document.getElementById('other_comments_wrap');
const otherField = document.getElementById('other_comments');

presetSelect.addEventListener('change', () => {
    const value = presetSelect.value;
    if (value === 'other') {
        otherWrap.classList.remove('d-none');
        commentsField.value = '';
        commentsField.readOnly = true;
        otherField.required = true;
    } else if (commentMap[value]) {
        otherWrap.classList.add('d-none');
        otherField.required = false;
        otherField.value = '';
        commentsField.readOnly = true;
        commentsField.value = commentMap[value];
    } else {
        otherWrap.classList.add('d-none');
        otherField.required = false;
        otherField.value = '';
        commentsField.readOnly = false;
        commentsField.value = '';
    }
});

otherField.addEventListener('input', () => {
    if (!otherWrap.classList.contains('d-none')) {
        commentsField.value = otherField.value;
    }
});
</script>
@endsection