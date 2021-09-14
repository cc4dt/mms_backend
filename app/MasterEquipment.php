<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterEquipment extends Model
{
    public function equipment(): BelongsTo
    {
        return $this->belongsTo('App\Equipment');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo('App\Station');
    }
    
    public function details(): HasMany
    {
        return $this->hasMany('App\MasterDetail');
    }
}
