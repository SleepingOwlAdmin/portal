<?php

namespace App;

use App\Contracts\ActivityableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $avatar_url
 * @property string $avatar_path
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $profile_link
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements ActivityableContract
{
    use \KodiComponents\Support\Upload,
        \App\Traits\Activityable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'avatar' => 'image'
    ];


    /**
     * @return array
     */
    public function getUploadSettings() // intervention image
    {
        return [
            'avatar' => [
                'fit' => [
                    300,
                    300,
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
    public function getProfileLinkAttribute()
    {
        return url('user/'.$this->id);
    }

    /**
     * @return int
     */
    public function authorId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getViewForActivity()
    {
        return 'activity.user';
    }
}
