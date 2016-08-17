<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Like
 *
 * @property integer $id
 * @property integer $likeable_id
 * @property string $likeable_type
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $likeable
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Like whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Like whereLikeableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Like whereLikeableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Like whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Like whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Like extends Model
{
    use \App\Traits\Authored;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'likes';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function likeable()
    {
        return $this->morphTo();
    }
}