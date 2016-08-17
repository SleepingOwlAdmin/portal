<?php

namespace App\Http\Api\Transformers;

use App\Notification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * @param Notification $notification
     *
     * @return array
     */
    public function transform(Notification $notification)
    {
        return $notification->toArray();
    }
}