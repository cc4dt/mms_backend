<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    // ticket statuses
    const OPENED = 'opened';
    const ASSGIND = 'waiting_for_access';
    const RECEIVED = 'received';
    const TRANSFER_TO_JOB = 'transfer_to_job';
    const WAIT_SPARE = 'waiting_for_spare_parts';
    const WAIT_APPROVAL = 'waiting_for_approval';
    const WAIT_CLIENT_APPROVAL = 'waiting_for_client_approval';
    const CLIENT_APPROVED = 'client_approved';
    const CLIENT_REVERSED = 'client_reversed';
    const PENDING = 'pending';
    const CLOSED = 'closed';
    const CANCELLED = 'cancelled';
    

    protected $appends = [
        'name',
    ];
    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }
}
