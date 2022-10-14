<?php

namespace App\Notifications;

use Exception;
use Illuminate\Notifications\Notification;
use NotifyLk\Api\SmsApi;

class SmsChannel extends Notification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = (object)$notification->toNotifySms($notifiable);

        $notify = new SmsApi();


        $user_id = config("notify.user_id");
        $api_key = config("notify.api_key");

        $sender_id = config("notify.sender_id");


        try {
            $notify->sendSMS(
                $user_id,
                $api_key,
                $message->message,
                $message->to,
                $sender_id
            );
        } catch (Exception $e) {
            throw new Exception('Exception when calling SmsApi->sendSMS: ' . $e->getMessage() . PHP_EOL);
        }

        // Send notification to the $notifiable instance...
    }
}
