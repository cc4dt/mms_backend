<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceDetail extends Model
{
    protected $fillable = [
        "sub_part_id",
        "spare_sub_part_id",
        "procedure_id",
        "value",
    ];

    public function sub_part(): BelongsTo
    {
        return $this->belongsTo(SubPart::class);
    }

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(MaintenanceProcedure::class);
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(MaintenanceProcess::class);
    }

    public function spare_sub_part(): BelongsTo
    {
        return $this->belongsTo(SpareSubPart::class);
    }

    
}
