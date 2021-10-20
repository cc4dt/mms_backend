<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use App\Ticket;

class TicketDeadline extends Notification
{
    use Queueable;

    public $ticket;
    public $time;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket, $time)
    {
        $this->ticket = $ticket;
        $this->time = $time;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', FcmChannel::class];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toFcm($notifiable)
    {
        $notification = $this->toArray($notifiable)["notification"];
        
        $data = $this->toArray($notifiable)["data"];
        $data["notification_id"] = $this->id;

        return FcmMessage::create()
            ->setData($data)
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($notification["title"])
                ->setBody($notification["body"]))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }
        
                

    // optional method when using kreait/laravel-firebase:^3.0, this method can be omitted, defaults to the default project
    public function fcmProject($notifiable, $message)
    {
        // $message is what is returned by `toFcm`
        return 'app'; // name of the firebase project to use
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "data" => [
                "id" => (string) $this->ticket->id,
                "type" => "ticket",
                "action" => "deadline",
                "notification_title" => __("message.ticket_deadline_title"),
                "notification_body" => __("message.ticket_deadline_body", ["time" => $this->time, "ticket_no" => $this->ticket->number, "station" => $this->ticket->station->name]),
            ],
            "notification" => [
                "title" => __("message.ticket_deadline_title"),
                "body" => __("message.ticket_deadline_body", ["time" => $this->time, "ticket_no" => $this->ticket->number, "station" => $this->ticket->station->name]),
            ]
        ];
    }
}
