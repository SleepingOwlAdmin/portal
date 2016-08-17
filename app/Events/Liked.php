<?php

namespace App\Events;

use App\Contracts\LikeableContract;
use App\Like;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Liked extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var LikeableContract
     */
    protected $model;

    /**
     * @var Like
     */
    protected $like;

    /**
     * @var User
     */
    protected $user;

    /**
     * Liked constructor.
     *
     * @param LikeableContract $model
     * @param Like $like
     * @param User $user
     */
    public function __construct(LikeableContract $model, Like $like, User $user)
    {
        $this->model = $model;
        $this->like = $like;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['liked'];
    }

    public function broadcastWith()
    {
        return [
            'likeable_id' => $this->like->likeable_id,
            'likeable_type' => $this->like->likeable_type,
            'user_id' => $this->user->id,
            'likes' => [
                'count' => $this->model->total_likes
            ]
        ];
    }

    /**
     * @return LikeableContract
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @return Like
     */
    public function like()
    {
        return $this->like;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }
}
