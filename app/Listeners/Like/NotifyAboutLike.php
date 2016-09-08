<?php

namespace App\Listeners\Like;

use App\Contracts\LikeableContract;
use App\Events\Liked;
use App\Mail\PostLiked;
use App\Notifications\LikedNotification;

class NotifyAboutLike
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
     * @param  Liked  $event
     * @return void
     */
    public function handle(Liked $event)
    {
        $author = $event->model()->getAuthor();

        $author->notify(new LikedNotification(
            $event->model(), $event->like()
        ));
    }
}
