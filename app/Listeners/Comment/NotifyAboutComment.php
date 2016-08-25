<?php

namespace App\Listeners\Comment;

use App\Events\CommentCreated;
use App\Notifications\Commented;
use App\Post;

class NotifyAboutComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentCreated  $event
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        $comment = $event->comment();

        /** @var Post $subject */
        $subject = $event->comment()->commentable;

        //if ($comment->getAuthor() != $subject->getAuthor()) {
            $subject->getAuthor()->notify(new Commented($comment));
       // }
    }
}
