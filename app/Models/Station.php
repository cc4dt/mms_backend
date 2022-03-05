<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{

    protected $appends = [
        'topCount',
    ];

    

    public function getTopCountAttribute()
    {
        return $this->tickets()->count();
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    
    public function equipment(): HasMany
    {
        return $this->hasMany(MasterEquipment::class);
    }
    
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function hses(): HasMany
    {
        return $this->hasMany(MasterHse::class);
    }
}