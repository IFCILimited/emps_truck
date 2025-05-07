<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $otp = rand(100000, 999999);
        $to = "sahiljassal9198@gmail.com";
        $cc = '';
        $bcc = '';
        $subject = env('APP_NAME') .' Portal - OTP';
        $from = 'noreply.pmedrive@heavyindustry.gov.in';

        return $this->subject($subject)
            ->view('emails.otp', ['otp' => $otp]);
    }
}
