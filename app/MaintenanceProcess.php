<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceProcess extends Model
{
    public function equipment(): BelongsTo
    {
        return $this->belongsTo('App\MasterEquipment');
    }

    public function equipment_part(): BelongsTo
    {
        return $this->belongsTo('App\Part');
    }

    public function details(): HasMany
    {
        return $this->hasMany('App\MaintenanceDetail');
    }
}
