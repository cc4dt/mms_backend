<?php

namespace App;

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
        return $this->belongsTo('App\Equipment');
    }

    public function master_equipment(): BelongsTo
    {
        return $this->belongsTo('App\MasterEquipment');
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo('App\Part');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo('App\Ticket');
    }

    public function timeline(): BelongsTo
    {
        return $this->belongsTo('App\TicketTimeline');
    }
    
    public function details(): HasMany
    {
        return $this->hasMany('App\MaintenanceDetail', 'process_id');
    }
}
