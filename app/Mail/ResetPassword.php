<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $resetUrl = URL::route('template', [
            'token' => $this->token,
            'email' => urlencode($this->email)
        ]);

        return $this->subject('Восстановление пароля')
            ->view('emails.reset')
            ->with([
                'resetUrl' => $resetUrl,
            ]);
    }
}