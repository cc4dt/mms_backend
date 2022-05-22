<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory;

    // actions
    const CREATE = 'create_ability';
    const READ = 'read_ability';
    const UPDATE = 'update_ability';
    const DELETE = 'delete_ability';
    const ALLOW = 'allow_ability';
    const DISALLOW = 'disallow_ability';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'label',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
