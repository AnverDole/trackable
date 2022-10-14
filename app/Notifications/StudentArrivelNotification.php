<?php

namespace App\Notifications;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StudentArrivelNotification extends Notification
{
    use Queueable;

    private $student;
    private $arrivelDateTime;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Student $student, $arrivelDateTime)
    {
        $this->student = $student;
        $this->arrivelDateTime = $arrivelDateTime;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * Get the sms representation of the notify API.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toNotifySms($notifiable)
    {
        $arrivelDateTime = $this->arrivelDateTime;
        $student = $this->student;

        return [
            "message" => "Hi {$notifiable->firstname},\nYour child {$student->firstname} {$student->lastname} arrived at the school at {$arrivelDateTime->format("H:i A")}.",
            "to" => $notifiable->telephone
        ];
    }
}
