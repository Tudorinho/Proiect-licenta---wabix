<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class AfterUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $user;
    public $model;
    public $context;
    public $originalModelAttributes;

    /**
     * Create a new event instance.
     */
    public function __construct($context, Request $request, Authenticatable $user, $model, $originalModelAttributes = null)
    {
        $this->context = $context;
        $this->request = $request;
        $this->user = $user;
        $this->model = $model;
        $this->originalModelAttributes = $originalModelAttributes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
