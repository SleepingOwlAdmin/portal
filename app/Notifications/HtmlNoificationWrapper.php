<?php

namespace App\Notifications;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Notifications\DatabaseNotification;

class HtmlNoificationWrapper implements Htmlable
{
    /**
     * @var DatabaseNotification
     */
    private $notification;

    /**
     * HtmlNoificationWrapper constructor.
     *
     * @param DatabaseNotification $notification
     */
    public function __construct(DatabaseNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        $template = 'notifications.'.snake_case(class_basename($this->notification->type));

        if (! view()->exists($template)) {
            $template = 'notifications.default';
        }

        return view($template, [
            'notification' => $this->notification
        ])->render();
    }
}