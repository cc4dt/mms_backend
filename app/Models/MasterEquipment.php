<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterEquipment extends Model
{
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
    
    public function processes(): HasMany
    {
        return $this->hasMany(MaintenanceProcess::class, 'equipment_id');
    }
    
    public function details(): HasMany
    {
        return $this->hasMany(MasterDetail::class, 'equipment_id');
    }
}
