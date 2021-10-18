<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketTimeline extends Model
{
    protected $fillable = [
        "status_id",
        "description",
        "created_by_id",
        "updated_by_id",
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo('App\Ticket');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo('App\TicketStatus');
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
