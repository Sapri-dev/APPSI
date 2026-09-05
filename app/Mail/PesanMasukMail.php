<?php

namespace App\Mail;

use App\Models\Pesan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PesanMasukMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pesan $pesan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[APPSI] Pesan Baru: ' . $this->pesan->subjek,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pesan-masuk',
            with: ['pesan' => $this->pesan],
        );
    }
}
