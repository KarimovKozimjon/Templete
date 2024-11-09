<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    // Konstruktor orqali foydalanuvchi va tasdiqlash URL-si
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->verificationUrl = route('verify.email', $user->verification_token);  // Tasdiqlash URL-si
    }

    public function build()
    {
        return $this->subject('Emailni tasdiqlash')
                    ->view('emails.verify');  // Tasdiqlash emaili
    }
}
