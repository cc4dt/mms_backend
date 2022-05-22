<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // actions
    const CREATE = 'create_role';
    const READ = 'read_role';
    const UPDATE = 'update_role';
    const DELETE = 'delete_role';
    const ASSIGN = 'assign_role';
    const UNASSIGN = 'unassign_role';

    const ROLE_ADMIN = 1;

    protected $hidden = ['pivot'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'label',
    ];
    public function abilities()
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function allowTo($ability)
    {
        // if the ability passed as text, then get its model
        if (is_string($ability)) {
            $ability = Ability::whereName($ability)->firstOrFail();
        }
        $this->abilities()->sync($ability, false);
    }

    public function disallow($ability)
    {
        // if the ability passed as text, then get its model
        if (is_string($ability)) {
            $ability = Ability::whereName($ability)->firstOrFail();
        }
        $this->abilities()->detach($ability);
    }
}
