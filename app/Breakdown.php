<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Breakdown extends Model
{

    protected $appends = [
        'name',
        'topCount',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo('App\Equipment');
    }
    
    public function tickets(): HasMany
    {
        return $this->hasMany('App\Ticket');
    }

    public function getTopCountAttribute()
    {
        return $this->tickets()->count();
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