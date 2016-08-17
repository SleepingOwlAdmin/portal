<?php

namespace App;

use App\Relations\ActivityMorphTo;
use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\Exception;

/**
 * App\Activity
 *
 * @property integer $id
 * @property integer $subject_id
 * @property string $subject_type
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activity whereSubjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activity whereSubjectType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activity whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use \App\Traits\Authored;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['subject'];


    public function render()
    {
        if (! $this->subject) {
            return;
        }

        $template = $this->subject->getViewForActivity();

        if (is_null($template)) {
            throw new Exception("Missed template for [{$this->subject_type}]");
        }

        return view($template, [
            'activity' => $this,
            'subject' => $this->subject
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return new ActivityMorphTo(
            $this->newQuery()->setEagerLoads([]), $this, 'subject_id', null, 'subject_type', 'subject'
        );
    }

    /**
     * @param $query
     * @param $type
     *
     * @return $query
     */
    public function scopeFilterByType($query, $type)
    {
        if(!is_array($type)) {
            $type = [$type];
        }

        $type = array_map(function($type) {
            return get_morph_type($type);
        }, $type);

        return $query->whereIn('subject_type', $type);
    }
}