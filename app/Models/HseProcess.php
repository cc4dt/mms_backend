<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HseProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'hse_id',
        'master_hse_id',
        'equipment_id',
        'description',
    ];

    public function master_hse(): BelongsTo
    {
        return $this->belongsTo(MasterHse::class);
    }

    public function hse(): BelongsTo
    {
        return $this->belongsTo(Hse::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(MasterEquipment::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(HseDetail::class, 'process_id');
    }
}
