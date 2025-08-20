<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class YourMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $title, $content;


    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }


    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->title);
    }

    public function content(): Content
    {
        return new Content(view: 'backend.layouts.newsletter.mailStyle', with: ['content' => $this->content]);
    }

    public function attachments(): array
    {
        return [];
    }
}


