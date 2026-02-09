<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Review $review;
    public bool $isForAuthor;

    public function __construct(Review $review, bool $isForAuthor = false)
    {
        $this->review = $review;
        $this->isForAuthor = $isForAuthor;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Review Submitted for: ' . $this->review->paper->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->isForAuthor ? 'emails.review-submitted-author' : 'emails.review-submitted-editor',
        );
    }
}