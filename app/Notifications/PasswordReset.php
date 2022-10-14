<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    private $firstname;
    private $token;
    private $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($firstname, $token, $email)
    {
        $this->firstname = $firstname;
        $this->token = $token;
        $this->email = $email;
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
        return (new MailMessage)
            ->subject("Forgot Password")
            ->markdown('notifications::password-reset', [
                "firstname" => $this->firstname,
                "token" => $this->token,
                "email" => $this->email
            ]);
    }
}
