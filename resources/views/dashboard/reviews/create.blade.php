@extends('layouts.app')
@section('title', 'Write Review')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Write Review</h2>
        <a href="{{ route('dashboard.reviews.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Reviews
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-alt"></i> Paper Details</h5>
                </div>
                <div class="card-body">
                    <h4>{{ $paper->title }}</h4>
                    <p class="text-muted">
                        <strong>Authors:</strong> {{ $paper->authors }}<br>
                        <strong>Submitted by:</strong> {{ $paper->user->name }}<br>
                        <strong>Submitted on:</strong> {{ $paper->submitted_at->format('M d, Y') }}
                    </p>
                    <hr>
                    <h5>Abstract</h5>
                    <p>{{ $paper->abstract }}</p>

                    @if($paper->keywords)
                    <div class="mt-3">
                        <strong>Keywords:</strong>
                        @foreach(explode(',', $paper->keywords) as $keyword)
                            <span class="badge bg-light text-dark me-1">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                    @endif

                    @if($paper->document_path)
                    <div class="mt-3">
                        <a href="{{ route('admin.papers.download', $paper) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-download"></i> Download Manuscript
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-pen"></i> Submit Your Review</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.reviews.store', $paper) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Reviewer Comment <span class="text-danger">*</span></label>
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
                            <label class="form-label">Recommendation <span class="text-danger">*</span></label>
                            <select name="recommendation" class="form-select" required>
                                <option value="">Select recommendation...</option>
                                <option value="accept" {{ old('recommendation') == 'accept' ? 'selected' : '' }}>Accept</option>
                                <option value="minor_revision" {{ old('recommendation') == 'minor_revision' ? 'selected' : '' }}>Minor Revision</option>
                                <option value="major_revision" {{ old('recommendation') == 'major_revision' ? 'selected' : '' }}>Major Revision</option>
                                <option value="reject" {{ old('recommendation') == 'reject' ? 'selected' : '' }}>Reject</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comments for Authors <span class="text-danger">*</span></label>
                            <textarea name="comments" id="comments" class="form-control" rows="6" required placeholder="Select a preset comment or write your own...">{{ old('comments') }}</textarea>
                        </div>
                        <div class="mb-3 d-none" id="other_comments_wrap">
                            <label class="form-label">Other Comments / Suggestions <span class="text-danger">*</span></label>
                            <textarea name="other_comments" id="other_comments" class="form-control" rows="5" placeholder="Write your comments here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confidential Comments for Editor</label>
                            <textarea name="confidential_comments" class="form-control" rows="3" placeholder="Optional notes visible only to the editor...">{{ old('confidential_comments') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-paper-plane"></i> Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
