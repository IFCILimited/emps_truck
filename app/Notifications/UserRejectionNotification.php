<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class UserRejectionNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $remarks;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $remarks)
    {
        $this->user = $user;
        $this->remarks = $remarks;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Define the notification channels here
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Account Rejected')
            ->line('Your account has been rejected with the following remarks:')
            ->line($this->remarks)
            ->action('Login', route('login'))
            ->line('Thank you for using our application!');
    }
}
