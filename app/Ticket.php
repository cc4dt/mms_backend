<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'teamleader',
        'created_by',
        'updated_by',
    ];


    public const STATUS = [
        "en" => [
            1 => 'Open',
            2 => 'Closed',
            3 => 'Cancelled',
            4 => 'Waiting for Spare Parts',
            5 => 'Waiting for Approval',
            6 => 'Waiting for Access',
            7 => 'Transfer To Job',
            8 => 'Pending',
            9 => 'Needs Approval From Client',
        ],
        "ar" => [
            1 => 'مفتوح',
            2 => 'مغلق',
            3 => 'ملغي',
            4 => 'بانتظار قطع غيار',
            5 => 'بانتظار موافقة الادارة',
            6 => 'بانتظار الوصول',
            7 => 'تم التحويل الى مهمة',
            8 => 'معلقة',
            9 => 'بانتظار موافقة العميل'
        ],
        1 => 'open',
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
        "en" => [
            1 => 'Corrective',
            2 => 'Breakdown',
            3 => 'Job',
            4 => 'Accident',
        ],
        "ar" => [
            1 => 'تصحيحي',
            2 => 'عطل',
            3 => 'عمل',
            4 => 'حادث',
        ],
        1 => 'corrective',
        2 => 'breakdown',
        3 => 'job',
        4 => 'accident',
    ];

    public const TRADE = [
        "en" => [
            1 => 'Mechanical',
            2 => 'Electrical',
        ],
        "ar" => [
            1 => 'ميكانيكي',
            2 => 'كهربائي',
        ],
        1 => 'mechanical',
        2 => 'electrical',
    ];

    public const PRIORITY = [
        "en" => [
            1 => 'Normal',
            2 => 'Urgent',
            3 => 'Emergency',
        ],
        "ar" => [
            1 => 'عادي',
            2 => 'عاجل',
            3 => 'طارئ',
        ],
        1 => 'normal',
        2 => 'urgent',
        3 => 'emergency',
    ];

    static public function constList($list)
    {
        $items = array();
        foreach ($list[app()->getLocale()] as $key => $value) {
            $items[] = (object) [
                "key" => $list[$key],
                "value" => $value
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
                "value" => self::TYPES[app()->getLocale()][$this->attributes['type_id']],
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
                "value" => self::STATUS[app()->getLocale()][$this->attributes['status_id']],
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
                "value" => self::TRADE[app()->getLocale()][$this->attributes['trade_id']],
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
                "value" => self::PRIORITY[app()->getLocale()][$this->attributes['priority_id']],
            ];
    }

    public function setPriorityAttribute($value)
    {
        $priorityID = array_search($value, self::PRIORITY);
        if ($priorityID) {
            $this->attributes['priority_id'] = $priorityID;
        }
    }
}