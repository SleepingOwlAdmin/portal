<?php

namespace App;

use App\Events\NotificationCreated;
use App\Services\MarkdownParser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Notification
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $icon
 * @property string $body
 * @property boolean $read
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $body_compiled
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification unread()
 * @method static \Illuminate\Database\Query\Builder|\App\Notification outdated()
 * @method static \Illuminate\Database\Query\Builder|\App\Notification forUser($user)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function (Notification $notification) {

            event(new NotificationCreated($notification));
        });
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'body_compiled',
    ];

    public function getBodyCompiledAttribute()
    {
        $result = MarkdownParser::parseText($this->attributes['body']);

        /**
         * @var string $intro
         * @var string $text
         * @var string $button_text
         * @var User[] $mentioned_users
         */
        extract($result);

        return $text;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $query
     */
    public function scopeUnread($query)
    {
        $query->where('read', false);
    }

    /**
     * @param $query
     */
    public function scopeOutdated($query)
    {
        $query->where('read', true)->where('created_at', '<', Carbon::now()->subDay(1));
    }

    /**
     * @param $query
     * @param int|User $user
     */
    public function scopeForUser($query, $user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        $query->where('user_id', $user);
    }
}