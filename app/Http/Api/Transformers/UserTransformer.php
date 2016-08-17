<?php

namespace App\Http\Api\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'links' => [
                'profile_link' => $user->profile_link,
                'avatar' => $user->avatar_url,
            ],
            'created_at' => $user->created_at->toDateTimeString(),
        ];
    }
}