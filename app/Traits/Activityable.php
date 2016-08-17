<?php

namespace App\Traits;

use App\Activity;

trait Activityable
{
    protected static function bootActivityable()
    {
        static::created(function ($subject) {
           $subject->recordActivity();
        });

        static::updated(function($subject) {
            $subject->updateActivity();
        });
    }

    public function recordActivity()
    {
        $this->activities()->create([
            'created_at' => $this->created_at,
            'user_id' => $this->authorId()
        ]);
    }

    public function updateActivity()
    {
        // Todo implement
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}