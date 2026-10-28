<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;

class VotingTokenMail extends Mailable
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Token Pemilihan',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.voting-token',
            with: [
                'token' => $this->token,
            ],
        );
    }
}