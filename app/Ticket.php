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
        'state_id',
        'station_id',
        'equipment_id',
        'breakdown_id',
        'open_description',
        'teamleader_id',
        'type_id',
        'trade_id',
        'priority_id',
        'work_description',
        'status_id',
        'created_by_id',
        'updated_by_id',
    ];

    protected $appends = [
        'load_time',
        'actions',
    ];

    static public function statusReported()
    {
        $items = array();
        $allTicketCount = Ticket::all()->count();
        foreach (TicketStatus::all() as $value) {
            $count = Ticket::where("status_id", $value->id)->count();
            $percentage = number_format((float) ($count / $allTicketCount * 100), 1, '.', '');
            $items[] = (object) [
                "id" => $value->id,
                "name" => $value->name,
                "count" => $count,
                "percentage" => $percentage
            ];
        }
        return $items;
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

    public function maintenance_processes(): HasMany
    {
        return $this->hasMany('App\MaintenanceProcess');
    }
    
    public function state(): BelongsTo
    {
        return $this->belongsTo('App\State');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo('App\Equipment');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo('App\TicketType');
    }

    public function trade(): BelongsTo
    {
        return $this->belongsTo('App\TicketTrade');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo('App\TicketPriority');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo('App\TicketStatus');
    }
    
    public function getLoadTimeAttribute($value)
    {
        return $this->created_at->diffInHours($this->updated_at);
    }
    
    public function getActionsAttribute($value)
    {
        $actions = [];
        foreach ($this->maintenance_processes as $process) {
            foreach ($process->details as $detail) {
                if($detail->procedure->type->key != "other")
                    $actions[] = $detail->procedure->name;
            }
        }
        return $actions;
    }

    static public function open($input)
    {
        $input['number'] = Carbon::now()->timestamp;
        $input['status_id'] = TicketStatus::where("key", "opened")->first()->id;
        $input['created_by_id'] = Auth::id();
        $input['updated_by_id'] = Auth::id();
        $ticket = Ticket::create($input);
        if($ticket) {
            
            try {
                Notification::send(User::supervisors(), new TicketOpened($ticket));
            } catch (\Throwable $th) {
                //throw $th;
            }
            return $ticket;
        }
    }

    public function assign($input)
    {
        $input['updated_by_id'] = Auth::id();
        $input['status_id'] = TicketStatus::where("key", "waiting_for_access")->first()->id;

        if ($this->update($input)) {
            try {
                $this->teamleader->notify(new TicketAssigned($this));
            } catch (\Throwable $th) {
                //throw $th;
            }
            // \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('NewTicketOpened', $this);
            return $this;
        }
    }

    public function close($input)
    {
        $this->updated_by_id = Auth::id();
        $this->status_id = isset($input['status_id']) ? $input['status_id'] : TicketStatus::where("key", "closed")->first()->id;
        $this->save();
        $process = new MaintenanceProcess();
        $process->ticket_id = $this->id;
        $process->equipment_id = $input['equipment_id'];
        $process->part_id = $input['part_id'];
        if ($process->save() && $this->save()) {
            foreach ($input['details'] as $item) {
                $detail = new MaintenanceDetail();
                $detail->process_id = $process->id;
                $detail->sub_part_id = $item['sub_part_id'];
                $detail->procedure_id = $item['procedure_id'];
                $detail->value = $item['value'];
                $detail->save();
            }
            return $this;
        }
    }

}
