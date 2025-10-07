<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $link;
    public function __construct($user, $link)
    {
        $this->user = $user;
        $this->link = $link;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password User',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.forgot_password',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
