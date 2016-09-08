<?php

namespace App\Events;

use App\Comment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentCreated extends Event implements ShouldBroadcast
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * Create a new event instance.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['comments'];
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'comment' => $this->comment
        ];
    }

    /**
     * @return Comment
     */
    public function comment()
    {
        return $this->comment;
    }
}
