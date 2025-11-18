<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AdminResetOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $expiresAt;

    public function __construct($otp, $expiresAt)
    {
        $this->otp = $otp;
        $this->expiresAt = $expiresAt;
    }

    public function build()
    {
        return $this->subject('Kode OTP Reset Password Admin')
                    ->view('emails.admin_reset_otp')
                    ->with([
                        'otp' => $this->otp,
                        'expiresAt' => $this->expiresAt,
                    ]);
    }
}
