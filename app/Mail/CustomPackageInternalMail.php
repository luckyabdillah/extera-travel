<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomPackageInternalMail extends Mailable
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
            subject: '[PENTING] Permintaan Paket Kustom Baru - ' . $this->data['name'],
        );
    }

    public function content(): Content
    {
        return (new Content)
            ->markdown('emails.custom-package-internal')
            ->with([
                'data' => $this->data,
            ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
