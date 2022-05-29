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
use Auth;
use Carbon\Carbon;
use Log;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    
    // user roles
    const ADMIN = 'admin';
    const SUPERVISORE = 'supervisor';
    const TEAMLEADER = 'teamleader';
    const DEALER = 'dealer';
    const SUPERCLIENT = 'super_client';
    const CLIENT = 'client';

    // user actions
    const CREATE = 'create_user';
    const READ = 'read_user';
    const UPDATE = 'update_user';
    const DELETE = 'delete_user';
    const VERFIY = 'verify_user';
    const ACTIVEUSER = 'active_user';
    const INACTIVEUSER = 'inactive_user';
    const CHANGE_EMAIL = 'change_email';
    const CHANGE_PASSWORD = 'change_password';

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
        'can_open_ticket',
        'can_open_client_ticket',
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
    
    public function getCanOpenTicketAttribute($value)
    {
        return $this->can('create', Ticket::class);
    }
    
    public function getCanOpenClientTicketAttribute($value)
    {
        return $this->can('create', [Ticket::class, true]);
    }


    public function master_roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function abilities()
    {
        return $this->master_roles->map->abilities->flatten()->pluck('name')->unique();
    }

    public function hasAbility($ability)
    {
        return $this->abilities()->contains($ability);
    }

    public function scopeHasRoles($q, $role)
    {
        return $q->whereHas('master_roles', function($q) use($role) {
            if(is_array($role))
                $q->whereIn("name", $role);
            else
                $q->where("name", $role);
        });
    }

    public function hasRole($role)
    {
        return $this->master_roles()->where(function($q) use($role) {
            if(is_array($role))
                $q->whereIn("name", $role);
            else
                $q->where("name", $role);
        })->count() > 0;
    }

    public function assignRole($role)
    {
        // if the role passed as text, then get its model
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }
        $this->roles()->sync($role, false);
    }

    public function unassignRole($role)
    {
        // if the role passed as text, then get its model
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }
        $this->roles()->detach($role);
    }

    public function isAdmin()
    {
        if ($this->roles()->pluck('name')->contains(self::ADMIN)) {
            return true;
        }

        return false;
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function scopeCreatedBetween(Builder $query, $from, $to = null): Builder
    {
        if(!$to) $to = Carbon::now()->toString();
        return $query->where('created_at', '>=', Carbon::parse($from))->where('created_at', '<=', Carbon::parse($to));
    }
    
    public function scopeAdmins($query)
    {
        $levelID = array_search('admin', self::LEVELS);
        return $query->where('level_id', $levelID);
    }
    
    public function scopeTeamleaders($query)
    {
        if(Auth::user()->hasRole([User::SUPERVISORE, User::ADMIN]))
            $query->hasRoles(User::TEAMLEADER);
        else if(Auth::user()->hasRole([User::DEALER, User::CLIENT]))
            $query->hasRoles(User::DEALER);
        return $query;
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

    public function scopeDealers($query)
    {
        $levelID = array_search('dealer', self::LEVELS);
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