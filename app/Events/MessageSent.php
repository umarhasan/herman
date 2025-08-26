<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {

        // Sender relation preload kar liya
        $this->message = $message->load('sender');
    }

    /**
     * Broadcast channel jahan message jayega.
     */
    public function broadcastOn()
    {
        // Har chat ka apna private channel
        return new PrivateChannel('chat.' . $this->message->chat_id);
    }

    /**
     * Broadcast ke sath jo data bhejna hai.
     */

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'chat_id' => $this->message->chat_id,
            'sender_id' => $this->message->sender_id, // 👈 ye line add karo
            'message' => $this->message->message,
            'created_at' => $this->message->created_at->toDateTimeString(),
            'sender' => [
                'id'   => $this->message->sender->id,
                'name' => $this->message->sender->name,
            ],
        ];
    }
}
