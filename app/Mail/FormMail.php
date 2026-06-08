<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    private string $viewName;

    public function __construct(string $subject, string $viewName, array $data, ?string $replyTo = null)
    {
        $this->subject = $subject;
        $this->viewName = $viewName;
        $this->data = $data;

        if ($replyTo) {
            $this->replyTo($replyTo);
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->viewName,
            with: $this->data,
        );
    }
}
