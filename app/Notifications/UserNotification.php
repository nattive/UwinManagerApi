<?php

namespace App\Notifications;
use App\User;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
// PresenceChannel
// notification
class UserNotification extends Notification
{
    use Queueable;

    public $type;
    public $body;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( User $user, $type, $body)
    {
        $this -> type =  $type;
        $this -> body =  $body;
        $this -> user =  $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
       return new PresenceChannel('notification.' .$this->user->id);
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => $type,
            'notification' => $notifiable,
        ];
    }
}
