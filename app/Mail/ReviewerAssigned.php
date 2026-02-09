<?php

namespace App\Mail;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewerAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public Paper $paper;
    public User $reviewer;

    public function __construct(Paper $paper, User $reviewer)
    {
        $this->paper = $paper;
        $this->reviewer = $reviewer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Review Request: ' . $this->paper->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reviewer-assigned',
        );
    }
}