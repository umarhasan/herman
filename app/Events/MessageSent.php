<?php
// app/Events/MessageSent.php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        // load sender details for broadcast payload
        $this->message = $message->load('sender');
    }

    public function broadcastOn()
    {
        // broadcast on private channel for the receiver
        return new PrivateChannel('chat.' . $this->message->receiver_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'created_at' => $this->message->created_at?->toDateTimeString(),
            'sender' => [
                'id' => $this->message->sender->id ?? null,
                'name' => $this->message->sender->name ?? null,
                'profile_image' => $this->message->sender->profile_image ?? null,
            ],
        ];
    }
}
