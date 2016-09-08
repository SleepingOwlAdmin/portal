<?php

namespace App\Http\Api\Transformers;

use App\Notifications\HtmlNoificationWrapper;
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
            'html' => (new HtmlNoificationWrapper($notification))->toHtml(),
            'type' => $notification->type,
            'read' => !is_null($notification->read_at),
            'data' => $notification->data
        ];
    }
}