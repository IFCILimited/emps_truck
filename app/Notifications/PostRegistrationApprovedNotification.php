<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use URL;

class PostRegistrationApprovedNotification extends Notification
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
        $loginUrl = URL::route('login'); // Assuming your login route is named 'login'

        return (new MailMessage)
            ->subject('Post Registration Approval Notification')
            ->greeting('Hello!')
            ->line('Your post-registration has been approved.')
            ->line('You can now proceed with the next steps.')
            ->action('View Details',  $loginUrl)
            ->line('Thank you for your cooperation.');
            // ->line('You can login to your account <a href="' . $loginUrl . '">here</a>.');
            
    }

    public function toArray($notifiable)
    {
        return [
            // Additional data to be stored in the notification
        ];
    }
}
