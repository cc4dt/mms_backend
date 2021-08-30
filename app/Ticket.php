<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketOpened;

class Ticket extends Model
{

    protected $fillable = [
        'number',
        'station_id',
        'breakdown_id',
        'open_description',
        'teamleader_id',
        'type',
        'trade',
        'priority',
        'work_description',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    protected $appends = [
        'status',
        'type',
        'trade',
        'priority',
    ];


    public const STATUS = [
        1 => 'opened',
        2 => 'closed',
        3 => 'cancelled',
        4 => 'waiting_for_spare_parts',
        5 => 'waiting_for_approval',
        6 => 'waiting_for_access',
        7 => 'transfer_to_job',
        8 => 'pending',
        9 => 'needs_approval_from_Client',
    ];

    public const TYPES = [
        1 => 'corrective',
        2 => 'breakdown',
        3 => 'job',
        4 => 'accident',
    ];

    public const TRADE = [
        1 => 'mechanical',
        2 => 'electrical',
    ];

    public const PRIORITY = [
        1 => 'normal',
        2 => 'urgent',
        3 => 'emergency',
    ];

    static public function statusReported()
    {
        $items = array();
        foreach (Ticket::STATUS as $key => $value) {
            $count = Ticket::where("status_id", $key)->count();
            $percentage = number_format((float) ($count / Ticket::all()->count() * 100), 1, '.', '');
            $items[] = (object) [
                "key" => Ticket::STATUS[$key],
                "name" => __('constants.'.$value),
                "count" => $count,
                "percentage" => $percentage
            ];
        }
        return $items;
    }

    static public function constList($list)
    {
        $items = array();
        foreach ($list as $key => $value) {
            $items[] = (object) [
                "key" => $value,
                "value" => __('constants.'.$value)
            ];
        }
        return $items;
    }

    static public function types()
    {
        return Ticket::constList(Ticket::TYPES);
    }

    static public function ticketStatus()
    {
        return Ticket::constList(Ticket::STATUS);
    }

    static public function trades()
    {
        return Ticket::constList(Ticket::TRADE);
    }

    static public function priorities()
    {
        return Ticket::constList(Ticket::PRIORITY);
    }

    public function teamleader(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo('App\Station');
    }


    public function breakdown(): BelongsTo
    {
        return $this->belongsTo('App\Breakdown');
    }

    public function getTypeAttribute()
    {
        if ($this->attributes['type_id'])
            return (object) [
                "key" => self::TYPES[$this->attributes['type_id']],
                "value" => __('constants.'.self::TYPES[$this->attributes['type_id']]),
            ];
    }

    public function setTypeAttribute($value)
    {
        $typeID = array_search($value, self::TYPES);
        if ($typeID) {
            $this->attributes['type_id'] = $typeID;
        }
    }

    public function getStatusAttribute()
    {
        if ($this->attributes['status_id'])
            return (object) [
                "key" => self::STATUS[$this->attributes['status_id']],
                "value" => __('constants.'.self::STATUS[$this->attributes['status_id']]),
            ];
    }

    public function setStatusAttribute($value)
    {
        $statusID = array_search($value, self::STATUS);
        if ($statusID) {
            $this->attributes['status_id'] = $statusID;
        }
    }

    public function getTradeAttribute()
    {
        if ($this->attributes['trade_id'])
            return (object) [
                "key" => self::TRADE[$this->attributes['trade_id']],
                "value" => __('constants.'.self::TRADE[$this->attributes['trade_id']]),
            ];
    }

    public function setTradeAttribute($value)
    {
        $tradeID = array_search($value, self::TRADE);
        if ($tradeID) {
            $this->attributes['trade_id'] = $tradeID;
        }
    }


    public function getPriorityAttribute()
    {
        if ($this->attributes['priority_id'])
            return (object) [
                "key" => self::PRIORITY[$this->attributes['priority_id']],
                "value" => __('constants.'.self::PRIORITY[$this->attributes['priority_id']]),
            ];
    }

    public function setPriorityAttribute($value)
    {
        $priorityID = array_search($value, self::PRIORITY);
        if ($priorityID) {
            $this->attributes['priority_id'] = $priorityID;
        }
    }
    
    static public function open($input)
    {
        $input['number'] = Carbon::now()->timestamp;
        $input['status'] = 'opened';
        $input['created_by_id'] = Auth::id();
        $input['updated_by_id'] = Auth::id();
        // Auth::user()->notify(new TicketOpened);
        $ticket = Ticket::create($input);
        Notification::send(User::supervisors(), new TicketOpened($ticket));
        return $ticket;
    }
    

    public function assign($input)
    {
        $input['updated_by_id'] = Auth::id();
        $input['status'] = 'waiting_for_access';

        if ($this->update($input)) {
            $this->teamleader->notify(new TicketAssigned($this));
            // \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('NewTicketOpened', $this);
            return $this;
        } else {
            return null;
        }
    }

}