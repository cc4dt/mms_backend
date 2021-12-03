<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceProcess extends Model
{
    protected $fillable = [
        "ticket_id",
        "equipment_id",
        "master_equipment_id",
        "part_id",
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function master_equipment(): BelongsTo
    {
        return $this->belongsTo(MasterEquipment::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(TicketTimeline::class);
    }
    
    public function details(): HasMany
    {
        return $this->hasMany(MaintenanceDetail::class, 'process_id');
    }
}
