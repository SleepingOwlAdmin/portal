<?php

namespace App\Events;

use App\Events\Event;
use App\Http\Api\Transformers\NotificationTransformer;
use App\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationCreated extends Event implements ShouldBroadcast
{
    /**
     * @var Notification
     */
    private $notification;

    /**
     * Create a new event instance.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'user.'.$this->notification->user_id
        ];
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'notification' => (new NotificationTransformer())->transform($this->notification)
        ];
    }

    /**
     * @return Notification
     */
    public function notification()
    {
        return $this->notification;
    }
}
