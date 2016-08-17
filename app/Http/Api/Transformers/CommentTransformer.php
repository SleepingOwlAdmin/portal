<?php

namespace App\Http\Api\Transformers;

use App\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * @param Comment $comment
     *
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'comment_source' => $comment->comment_source,
            'created_at' => $comment->created_at->toDateTimeString(),
            'user' => null,
            'likes' => [
                'count' => (int) $comment->total_likes
            ]
        ];
    }

    /**
     * @param Comment $comment
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Comment $comment)
    {
        return $this->item($comment->user, new UserTransformer());
    }
}