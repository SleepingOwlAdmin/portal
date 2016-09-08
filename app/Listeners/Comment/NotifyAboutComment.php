<?php

namespace App\Listeners\Comment;

use App\Events\CommentCreated;
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

    }
}
