<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetUrl;
    public string $token;
    public string $userName;

    public function __construct(string $resetUrl, string $token, string $userName)
    {
        $this->resetUrl = $resetUrl;
        $this->token = $token;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Reset Password Akun Anda')
            ->view('emails.reset_password');
    }
}