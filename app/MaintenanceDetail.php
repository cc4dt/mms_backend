<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceDetail extends Model
{
    protected $fillable = [
        "sub_part_id",
        "procedure_id",
        "value",
    ];

    public function sub_part(): BelongsTo
    {
        return $this->belongsTo('App\SubPart');
    }

    public function procedure(): BelongsTo
    {
        return $this->belongsTo('App\MaintenanceProcedure');
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo('App\MaintenanceProcess');
    }

    public function spare_sub_part(): BelongsTo
    {
        return $this->belongsTo('App\SpareSubPart');
    }

    
}
