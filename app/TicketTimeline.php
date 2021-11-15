<?php

namespace App;

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

    public function getTimestampAttribute($value) : Carbon
    {
        return new Carbon($value);
    }
    
    public function ticket(): BelongsTo
    {
        return $this->belongsTo('App\Ticket');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo('App\TicketStatus');
    }
    
    public function maintenance_processes(): HasMany
    {
        return $this->hasMany('App\MaintenanceProcess', 'timeline_id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }
}
