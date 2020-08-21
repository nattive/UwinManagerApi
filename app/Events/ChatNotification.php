<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\ChatMessage;
class ChatNotification  implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiver;
    public $sender;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatMessage $message, User $receiver, User $sender)
    {
        $this -> message = $message;
        $this -> sender = $sender;
        $this -> receiver = $receiver;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('notification.'.$this -> receiver -> id);
    }
      public function broadcastAs()
    {
        // Log::info($message);
        return 'notification';
    }
}
