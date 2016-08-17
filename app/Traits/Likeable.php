<?php

namespace App\Traits;

use App\Events\Disliked;
use App\Events\Liked;
use App\Like;
use App\User;

trait Likeable
{

    protected static function bootLikeable()
    {
        static::deleted(function ($model) {
            $model->likes()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function likes_count()
    {
        return $this->morphOne(Like::class, 'likeable')
            ->selectRaw('count(*) as aggregate, likeable_id')
            ->groupBy('likeable_id', 'likeable_type');
    }

    /**
     * @return int
     */
    public function getTotalLikesAttribute()
    {
        if (! array_key_exists('likes_count', $this->relations)) {
            $this->load('likes_count');
        }

        $related = $this->getRelation('likes_count');

        return $related ? (int) $related->aggregate : 0;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function like(User $user)
    {
        if ($this->likedByUser($user)) {
            return false;
        }

        $like = new Like();
        $like->assignUser($user);
        $this->likes()->save($like);

        event(new Liked($this, $like, $user));
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function dislike(User $user)
    {
        /** @var Like $like */
        if (is_null($like = $this->likes()->where('user_id', $user->id)->first())) {
            return false;
        }

        $like->delete();

        event(new Disliked($this, $like, $user));
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function likedByUser(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->count() > 0;
    }
}