<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'company_id',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'level',
        'profile_photo_url',
    ];

    public const LEVELS = [
        1 => 'admin',
        2 => 'supervisor',
        3 => 'teamleader',
        4 => 'dealer',
        5 => 'client',
    ];

    static public function constList($list)
    {
        $items = array();
        foreach ($list as $key => $value) {
            $items[] = (object) [
                "key" => $value,
                "value" => __('constants.'.$value)
            ];
        }
        return $items;
    }

    static public function levels()
    {
        return User::constList(User::LEVELS);
    }


    public function scopeCreatedBetween(Builder $query, $from, $to = null): Builder
    {
        if(!$to) $to = Carbon::now()->toString();
        return $query->where('created_at', '>=', Carbon::parse($from))->where('created_at', '<=', Carbon::parse($to));
    }
    
    public function scopeTeamleaders($query)
    {
        $levelID = array_search('teamleader', self::LEVELS);
        return $query->where('level_id', $levelID);
    }

    public function scopeSupervisors($query)
    {
        $levelID = array_search('supervisor', self::LEVELS);
        return $query->where('level_id', $levelID);
    }

    public function scopeClients($query)
    {
        $levelID = array_search('client', self::LEVELS);
        return $query->where('level_id', $levelID);
    }
    
    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLevelAttribute()
    {
        if ($this->attributes['level_id'])
            return (object) [
                "key" => self::LEVELS[$this->attributes['level_id']],
                "value" => __('constants.'.self::LEVELS[$this->attributes['level_id']]),
            ];
    }

    public function setLevelAttribute($value)
    {
        $levelID = array_search($value, self::LEVELS);
        if ($levelID) {
            $this->attributes['level_id'] = $levelID;
        }
    }
    
    public function fcmTokens(): HasMany
    {
        return $this->hasMany(FcmToken::class);
    }
    
    public function isAdmin()
    {
        if($this->level->key == "admin")
            return true;
        else
            return false;
    }
    
    public function isSupervisor()
    {
        if($this->level->key == "supervisor")
            return true;
        else
            return false;
    }
    
    public function isTeamleader()
    {
        if($this->level->key == "teamleader")
            return true;
        else
            return false;
    }
    
    public function isDealer()
    {
        if($this->level->key == "dealer")
            return true;
        else
            return false;
    }
    
    public function isClient()
    {
        if($this->level->key == "client")
            return true;
        else
            return false;      
    }

    public function getDeviceTokens()
    {
        $tokens = [];
        foreach ($this->fcmTokens as $value) {
            $tokens[] = $value->token;
        }
        return $tokens;
    }

    public function routeNotificationForFcm()
    {
        return $this->getDeviceTokens();
    }
}