<?php

namespace App\Listeners\Like;

use App\Contracts\LikeableContract;
use App\Events\Liked;

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
        $like = $event->like();
        $subject = $like->likeable;

        if ($subject instanceof LikeableContract) {
            $author = $subject->getAuthor();

            $author->notify(new \App\Notifications\Liked($subject));
        }
    }
}
