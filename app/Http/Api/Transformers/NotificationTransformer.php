<?php

namespace App\Http\Api\Transformers;

use Illuminate\Notifications\DatabaseNotification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * @param DatabaseNotification $notification
     *
     * @return array
     */
    public function transform(DatabaseNotification $notification)
    {
        return [
            'id' => $notification->id,
            'type' => $notification->type,
            'is_read' => !is_null($notification->read_at),
            'data' => $notification->data
        ];
    }
}