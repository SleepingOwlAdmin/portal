<?php

namespace App\Repositories;

use App\Notification;
use App\User;

class NotificationsRepository
{
    /**
     * @param User $user
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function recent(User $user)
    {
        return Notification::forUser($user)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    public function markAsRead(User $user, array $ids)
    {
        Notification::whereIn('id', $ids)
            ->forUser($user)
            ->update(['read' => true]);
    }

    /**
     * @param User $user
     * @param array $data
     *
     * @return Notification
     */
    public function create(User $user, array $data)
    {
        return Notification::create([
           'user_id' => $user->id,
            'icon' => array_get($data, 'icon'),
            'body' => array_get($data, 'body')
        ]);
    }
}