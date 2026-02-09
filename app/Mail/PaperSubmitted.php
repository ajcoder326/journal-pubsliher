<?php

namespace App\Mail;

use App\Models\Paper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaperSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Paper $paper;
    public bool $isForEditor;

    public function __construct(Paper $paper, bool $isForEditor = false)
    {
        $this->paper = $paper;
        $this->isForEditor = $isForEditor;
    }

    public function envelope(): Envelope
    {
        $subject = $this->isForEditor 
            ? 'New Paper Submission: ' . $this->paper->title
            : 'Paper Submitted Successfully: ' . $this->paper->title;
            
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: $this->isForEditor ? 'emails.paper-submitted-editor' : 'emails.paper-submitted-author',
        );
    }
}