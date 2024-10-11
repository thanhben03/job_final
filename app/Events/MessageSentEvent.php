<?php

namespace App\Events;

use App\Http\Resources\ChatResource;
use App\Http\Resources\ChatSingleResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Create a new event instance.
     */
    public function __construct(
        protected Chat $message
    )
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        if ($this->message->sender == 'user') {
            return new PrivateChannel('message.company.'.$this->message->company_id);
        }
        return new PrivateChannel('message.'.$this->message->user_id);
    }

    public function broadcastWith(): array {
        return [
            'message' => ChatSingleResource::make($this->message)->resolve(),
        ];
    }
}
