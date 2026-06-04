<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendingEmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $oldEmail,
        public string $newEmail,
        public string $verificationUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Perubahan Email — Delix Studio',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pending-email-verification',
            with: [
                'name' => $this->name,
                'oldEmail' => $this->oldEmail,
                'newEmail' => $this->newEmail,
                'verificationUrl' => $this->verificationUrl,
            ],
        );
    }
}
