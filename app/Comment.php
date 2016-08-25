<?php

namespace App;

use App\Contracts\LikeableContract;
use App\Events\CommentCreated;
use App\Services\MarkdownParser;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $commentable_id
 * @property string $commentable_type
 * @property string $comment
 * @property string $comment_source
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Like[] $likes
 * @property-read \App\Like $likes_count
 * @property-read mixed $total_likes
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereCommentSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Comment extends Model implements LikeableContract
{
    use \App\Traits\Likeable,
        \App\Traits\Authored,
        \Illuminate\Database\Eloquent\SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::created(function (Comment $comment) {

            event(new CommentCreated($comment));
        });
    }


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_source'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user', 'likes_count'
    ];

    /**
     * @param string $mdComment
     */
    public function setCommentSourceAttribute($mdComment)
    {
        $this->attributes['comment_source'] = $mdComment;

        $result = MarkdownParser::parseComment($mdComment);

        /**
         * @var string $comment
         * @var User[] $mentioned_users
         */
        extract($result);

        $this->comment = $comment;
        // TODO set mentioned users
        // $this->mentioned_users = $comment;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->user;
    }
}