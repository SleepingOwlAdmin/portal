<?php

namespace App\Relations;

use App\Contracts\ActivityableContract;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityMorphTo extends MorphTo
{
    public function createModelByType($type)
    {
        $instance = parent::createModelByType($type);

        if ($instance instanceof ActivityableContract and method_exists($instance, 'onActivityMorphing')) {
            $instance->onActivityMorphing();
        }

        return $instance;
    }
}