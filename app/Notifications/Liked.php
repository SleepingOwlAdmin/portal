<?php

namespace App\Notifications;

use App\Contracts\LikeableContract;
use App\Http\Api\Transformers\LikeTransformer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Liked extends Notification
{
    use Queueable;

    /**
     * @var LikeableContract
     */
    private $model;

    /**
     * Create a new notification instance.
     *
     * @param LikeableContract $model
     */
    public function __construct(LikeableContract $model)
    {
        $this->model = $model;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->line('The introduction to the notification.')->action('Notification Action', 'https://laravel.com')->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return $this->model->toArray();
    }

    /**
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        return [
            'data' => $this->toDatabase($notifiable)
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [//
        ];
    }
}
