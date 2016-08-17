<?php

namespace App\Traits;

use App\Comment;
use App\User;

trait Commentable
{
    protected static function bootCommentable()
    {
        static::deleting(function($model) {
           $model->comments()->forceDelete();
        });
    }

    /**
     * @param string $text
     * @param User $user
     *
     * @return Comment|void
     */
    public function addComment($text, User $user)
    {
        if(!$this->exists) {
            return;
        }

        $comment = new Comment();
        $comment->comment_source = $text;
        $comment->commentable()->associate($this);
        $comment->assignUser($user);
        $comment->save();

        return $comment;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function comments_count()
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->selectRaw('count(*) as aggregate, commentable_id')
            ->groupBy('commentable_id', 'commentable_type');
    }

    /**
     * @return int
     */
    public function getTotaCommentsAttribute()
    {
        if (! array_key_exists('comments_count', $this->relations)) {
            $this->load('comments_count');
        }

        $related = $this->getRelation('comments_count');

        return $related ? (int) $related->aggregate : 0;
    }
}