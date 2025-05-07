<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OEMRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->subject('EMPS Portal - Registration')->view('emails.registration',['user'=> $this->user]);
        // return $this->view('view.name');
        return $this->subject(env('APP_NAME') . ' Portal - Registration')
            ->view('emails.registration', ['user' => $this->user]);

    }
}
