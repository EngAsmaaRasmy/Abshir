<?php

namespace App\Events;

use App\Models\shop\ShopNotificationModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReceiveMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public function __construct(ShopNotificationModel $notification)
    {
        $this->notification=$notification;
    }

    public function broadcastOn()
    {
        return new channel('messagesChannel');
    }
}
