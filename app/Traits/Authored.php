<?php

namespace App\Traits;

use App\User;

trait Authored
{
    /**
     * @param User $user
     */
    public function assignUser(User $user)
    {
        $this->user()->associate($user);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isAuthoredBy(User $user)
    {
        return $this->user_id == $user->id;
    }

    /**
     * @return int
     */
    public function authorId()
    {
        return $this->user_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}