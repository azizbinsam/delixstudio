<?php

namespace App\Mail;

use App\Models\PaymentSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailChangedNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $whatsappUrl;

    public function __construct(
        public User $user,
        public string $oldEmail,
        public string $newEmail
    ) {
        $setting = PaymentSetting::first();

        $this->whatsappUrl = '';

        if ($setting?->whatsapp_number) {
            $number = preg_replace('/\D/', '', $setting->whatsapp_number);
            $number = preg_replace('/^0/', '62', $number);
            $text = urlencode(
                "Halo, saya {$user->name} ({$oldEmail}). " .
                    "Saya tidak melakukan perubahan email pada akun Delix Studio saya. " .
                    "Mohon bantuan untuk mengamankan akun saya."
            );

            $this->whatsappUrl = "https://wa.me/{$number}?text={$text}";
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Kamu Telah Diubah — Delix Studio',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-changed-notification',
            with: [
                'user' => $this->user,
                'oldEmail' => $this->oldEmail,
                'newEmail' => $this->newEmail,
                'whatsappUrl'  => $this->whatsappUrl,
            ],
        );
    }
}
