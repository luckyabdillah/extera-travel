<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomPackageMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Paket Kustom Diterima - Extera Travel',
        );
    }

    public function content(): Content
    {
        return (new Content)
            ->markdown('emails.custom-package-customer')
            ->with([
                'data' => $this->data,
            ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
