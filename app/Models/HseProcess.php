<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HseProcess extends Model
{
    protected $fillable = [
        'hse_id',
        'station_id',
        'master_equipment_id',
        'timestamp',
        'created_by_id',
        'updated_by_id',
    ];

    public function hse(): BelongsTo
    {
        return $this->belongsTo(Hse::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function master_equipment(): BelongsTo
    {
        return $this->belongsTo(MasterEquipment::class);
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(HseDetail::class, 'process_id');
    }
}
