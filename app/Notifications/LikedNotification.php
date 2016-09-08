<?php

namespace App\Notifications;

use App\Contracts\LikeableContract;
use App\Like;
use Illuminate\Notifications\Notification;

class LikedNotification extends Notification
{
    /**
     * @var LikeableContract
     */
    protected $subject;

    /**
     * @var Like
     */
    protected $like;

    /**
     * Create a new notification instance.
     *
     * @param LikeableContract $subject
     * @param Like $like
     */
    public function __construct(LikeableContract $subject, Like $like)
    {
        $this->subject = $subject;
        $this->like = $like;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'icon' => 'heart green',
            'text' => 'Ваш объект был лайкнут пользователем '.$this->like->user->name,
            'subject' => $this->subject,
            'author' => $this->like->user,
        ];
    }
}
