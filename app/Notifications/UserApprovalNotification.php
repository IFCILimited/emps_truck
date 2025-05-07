<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Crypt;
use URL;

class UserApprovalNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
        $encryptedUserId = Crypt::encrypt($this->user->id);

         // Define the expiration time (e.g., 60 minutes from now)
    $expiration = now()->addMinutes(60);

    // Generate a signed URL with the expiration time
    $url = URL::temporarySignedRoute('post_registration', $expiration, ['id' => $encryptedUserId]);

    return (new MailMessage)
        ->subject('Your account has been approved')
        ->greeting('Hello ' . $this->user->name)
        ->line('Your account has been approved. You can now proceed with registration.')
        ->action('Register Now', $url)
        ->line('Thank you for using our application!');

        // return (new MailMessage)
        //     ->subject('Your account has been approved')
        //     ->greeting('Hello ' . $this->user->name)
        //     ->line('Your account has been approved. You can now proceed with registration.')
        //     // ->action('Register Now', route('post_registration', ['id' => $this->user->id]))
        //     ->action('Register Now', route('post_registration', ['id' => $encryptedUserId]))
        //     ->line('Thank you for using our application!');
    }
}
