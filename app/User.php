<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $appends = [
        'level',
        'created_by',
        'updated_by',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public const LEVELS = [
        "en" => [
            1 => 'Admin',
            2 => 'Supervisor',
            3 => 'Teamleader',
            4 => 'Dealer',
            5 => 'Client',
        ],
        "ar" => [
            1 => 'مدير',
            2 => 'مالك',
            3 => 'قائد الفريق',
            4 => 'خدمات العملاء',
            5 => 'عميل',

        ],
        1 => 'admin',
        2 => 'supervisor',
        3 => 'teamleader',
        4 => 'dealer',
        5 => 'client',
    ];

    static public function constList($list)
    {
        $items = array();
        foreach ($list[app()->getLocale()] as $key => $value) {
            $items[] = (object) [
                "key" => $list[$key],
                "value" => $value
            ];
        }
        return $items;
    }

    static public function levels()
    {
        return User::constList(User::LEVELS);
    }

    static public function teamleaders()
    {
        $levelID = array_search('teamleader', self::LEVELS);
        return User::where('level_id', $levelID)->get();
    }


    public function updated_by(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function getLevelAttribute()
    {
        return (object) [
            "key" => self::LEVELS[$this->attributes['level_id']],
            "value" => self::LEVELS[app()->getLocale()][$this->attributes['level_id']],
        ];
    }

    public function setLevelAttribute($value)
    {
        $levelID = array_search($value, self::LEVELS);
        if ($levelID) {
            $this->attributes['level_id'] = $levelID;
        }
    }
}