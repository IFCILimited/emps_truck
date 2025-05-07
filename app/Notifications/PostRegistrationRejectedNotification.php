<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use URL;

class PostRegistrationRejectedNotification extends Notification
{
    use Queueable;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Post Registration Rejection Notification')
            ->greeting('Hello!')
            ->line('Your post-registration has been rejected.')
            // ->line('Please review the provided information and make necessary corrections.')
            // ->action('View Details', url('/'))
            ->line('Thank you for your understanding.');
    }

    public function toArray($notifiable)
    {
        return [
            // Additional data to be stored in the notification
        ];
    }
}
