<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterDetail extends Model
{
    public function equipment(): BelongsTo
    {
        return $this->belongsTo('App\MasterEquipment');
    }
    

    public function attribute(): BelongsTo
    {
        return $this->belongsTo('App\Attribute');
    }
}
