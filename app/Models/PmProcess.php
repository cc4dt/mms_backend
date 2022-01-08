<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PmProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'pm_id',
        'master_equipment_id',
        'equipment_id',
        'description',
    ];

    public function pm(): BelongsTo
    {
        return $this->belongsTo(Pm::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function master_equipment(): BelongsTo
    {
        return $this->belongsTo(MasterEquipment::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(PmDetail::class, 'process_id');
    }
}
