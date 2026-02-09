<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DynamicTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $templateName;
    public array $placeholders;
    protected ?EmailTemplate $template;

    public function __construct(string $templateName, array $placeholders = [])
    {
        $this->templateName = $templateName;
        $this->placeholders = $placeholders;
        $this->template = EmailTemplate::where('name', $templateName)->first();
    }

    public function envelope(): Envelope
    {
        $subject = $this->template ? $this->template->subject : 'DE-Journal Notification';
        
        foreach ($this->placeholders as $key => $value) {
            $subject = str_replace('{' . $key . '}', $value, $subject);
        }

        return new Envelope(
            subject: $subject,
        );
    }

    public function build()
    {
        if (!$this->template) {
            return $this->view('emails.fallback')
                       ->with(['message' => 'Template not found: ' . $this->templateName]);
        }

        $body = $this->template->body;
        
        foreach ($this->placeholders as $key => $value) {
            $body = str_replace('{' . $key . '}', $value, $body);
        }

        return $this->view('emails.template')
                   ->with([
                       'body' => $body,
                       'templateName' => $this->templateName,
                   ]);
    }

    public function attachments(): array
    {
        return [];
    }
}