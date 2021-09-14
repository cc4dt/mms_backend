<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceDetail extends Model
{
    public function equipmentSubPart(): BelongsTo
    {
        return $this->belongsTo('App\EquipmentSubPart');
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo('App\Attribute');
    }
}
