<?php

namespace App\Mail;

use App\Models\Paper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaperStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public Paper $paper;
    public string $oldStatus;
    public string $newStatus;

    public function __construct(Paper $paper, string $oldStatus, string $newStatus)
    {
        $this->paper = $paper;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Paper Status Update: ' . $this->paper->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.paper-status-changed',
        );
    }
}