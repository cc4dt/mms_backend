<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class TicketTimeline extends Model
{
    protected $fillable = [
        "status_id",
        "description",
        "timestamp",
        "created_by_id",
        "updated_by_id",
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function getTimestampAttribute($value) : Carbon
    {
        return new Carbon($value);
    }
    
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class);
    }
    
    public function maintenance_processes(): HasMany
    {
        return $this->hasMany(MaintenanceProcess::class, 'timeline_id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
