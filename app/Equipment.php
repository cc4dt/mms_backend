<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{

    protected $appends = [
        'name',
    ];

    public function parts(): HasMany
    {   
        return $this->hasMany('App\EquipmentPart');
    }

    public function breakdowns(): HasMany
    {
        return $this->hasMany('App\Breakdown');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany('App\Attribute');
    }

    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }
}