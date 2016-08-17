<?php

namespace App\Http\Api\Transformers;

use App\Like;
use League\Fractal\TransformerAbstract;

class LikeTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * @param Like $like
     *
     * @return array
     */
    public function transform(Like $like)
    {
        return [
            'id' => $like->id,
            'created_at' => $like->created_at->toDateTimeString(),
            'user' => null,
        ];
    }

    /**
     * @param Like $like
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Like $like)
    {
        return $this->item($like->user, new UserTransformer());
    }
}