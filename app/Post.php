<?php

namespace App;

use App\Contracts\ActivityableContract;
use App\Contracts\CommentableContract;
use App\Contracts\LikeableContract;
use App\Services\MarkdownParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * App\Post
 *
 * @property integer $id
 * @property string $title
 * @property string $text_intro
 * @property string $text
 * @property string $text_source
 * @property string $image
 * @property string $thumb
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property string $cut_text
 * @property-write mixed $upload_image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Like[] $likes
 * @property-read \App\Like $likes_count
 * @property-read mixed $total_likes
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereTextIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereTextSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereThumb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCutText($value)
 * @mixin \Eloquent
 */
class Post extends Model implements ActivityableContract, LikeableContract, CommentableContract
{
    use \KodiComponents\Support\Upload, \App\Traits\Activityable, \App\Traits\Authored, \App\Traits\Likeable, \App\Traits\Commentable, \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text_source',
        'title',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'image',
        'thumb' => 'image',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'image_url',
        'image_path', // From Upload trait
        'thumb_url',
        'thumb_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['text_source'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user',
        'likes_count',
    ];

    /**
     * @return array
     */
    public function getUploadSettings() // intervention image
    {
        return [
            'image' => [
                'resize' => [
                    800,
                    null,
                    function ($const) {
                        $const->upsize();
                        $const->aspectRation();
                    },
                ],
            ],
            'thumb' => [
                'resize' => [
                    150,
                    null,
                    function ($const) {
                        $const->upsize();
                        $const->aspectRation();
                    },
                ],
            ],
        ];
    }

    /********************************
     * Mutators
     *******************************/

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getLinkAttribute()
    {
        return url('post/'.$this->id);
    }

    /**
     * @param string $mdText
     */
    public function setTextSourceAttribute($mdText)
    {
        $this->attributes['text_source'] = $mdText;

        $result = MarkdownParser::parseText($mdText);

        /**
         * @var string $intro
         * @var string $text
         * @var string $button_text
         * @var User[] $mentioned_users
         */
        extract($result);

        $this->text_intro = $intro;
        $this->text = $text;
        $this->cut_text = $button_text;
        // TODO set mentioned users
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setUploadImageAttribute(UploadedFile $file = null)
    {
        foreach ($this->getUploadFields() as $field) {
            $this->{$field.'_file'} = $file;
        }
    }

    /**
     * @param $query
     */
    public function scopeLatest($query)
    {
        $query->orderBy('created_at', 'desc');
    }

    /**
     * @return string
     */
    public function getViewForActivity()
    {
        return 'activity.post';
    }

    public function onActivityMorphing()
    {
        $this->with = ['comments_count', 'likes_count'];
    }
}