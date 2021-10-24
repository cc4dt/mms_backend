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
use App\Notifications\TicketClosed;

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
        'led_time',
        'deadline',
        'sla',
        'in_sla',
        'actions',
        'timeline',
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
    
    static public function daily()
    {
        return Ticket::whereDate('created_at', Carbon::today())
        ->orderBy('created_at', 'desc')->get();
    }
        
    static public function monthly()
    {
        return Ticket::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)  
        ->whereHas('status',  function($q) {
            $q->where("key", "!=", "closed");
         })  
         ->whereHas('status',  function($q) {
             $q->where("key", "!=", "cancelled");
          })
        ->orderBy('created_at', 'desc')->get();
    }

    static public function inSLA() {
        return Ticket::whereHas('type',  function($q) {
            $q->where("key", "breakdown");
         })
         ->whereHas('status',  function($q) {
            $q->where("key", "closed");
         })
         ->where(function($qp) {
            $qp->where(function($q) {
               $q->whereHas('priority',  function($q) {
                  $q->where("key", "normal");
               });
               $q->whereRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) <= ?', [72]);
            })
            ->orWhere(function($q) {
               $q->whereHas('priority',  function($q) {
                  $q->where("key", "urgent");
               });
               $q->whereRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) <= ?', [24]);
            })
            ->orWhere(function($q) {
               $q->whereHas('priority',  function($q) {
                  $q->where("key", "emergency");
               });
               $q->whereRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) <= ?', [5]);
            });
         })
         ->get();
    }

    static public function outSLA() {
        return Ticket::whereHas('type',  function($q) {
            $q->where("key", "breakdown");
         })
         ->whereHas('status',  function($q) {
            $q->where("key", "closed");
         })
         ->where(function($qp) {
            $qp->where(function($q) {
               $q->whereHas('priority',  function($q) {
                  $q->where("key", "normal");
               });
               $q->whereRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) > ?', [72]);
            })
            ->orWhere(function($q) {
               $q->whereHas('priority',  function($q) {
                  $q->where("key", "urgent");
               });
               $q->whereRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) > ?', [24]);
            })
            ->orWhere(function($q) {
               $q->whereHas('priority',  function($q) {
                  $q->where("key", "emergency");
               });
               $q->whereRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) > ?', [5]);
            });
         })
         ->get();
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

    public function timelines(): HasMany
    {
        return $this->hasMany('App\TicketTimeline');
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
    
    public function getLedTimeAttribute($value)
    {
        if($this->status->key == "closed") {
            $totalDuration = $this->created_at->diffInSeconds($this->updated_at);
            return floor($totalDuration / 3600) . gmdate(":i", $totalDuration % 3600);
        }
    }
    
    public function getDeadlineAttribute($value)
    {
        if($this->sla) {
            $deadline = $this->created_at->copy()->addHours($this->sla);
            if($deadline >= Carbon::now())
                return $deadline;
        }
    }

    public function getSlaAttribute($value)
    {
        if($this->priority) {
            if($this->priority->key == "normal") {
                return 72;
            }
            elseif ($this->priority->key == "urgent") {
                return 24;
            }
            elseif ($this->priority->key == "emergency") {
                return 5;
            }
        }
        return 0;
    }

    public function getTimelineAttribute($value)
    {
        if($this->timelines) {
            return $this->timelines()->orderBy('created_at', 'desc')->first();
        }
    }
    
    public function getInSlaAttribute($value)
    {
        foreach ($this->timelines as $value) {
            if($value->status->key == 'closed' && $value->created_at) {
                $hours = $this->created_at->diffInHours($value->created_at);
                if ($this->sla && $hours <= $this->sla) {
                    return true;
                }
            }
        }
        return false;
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
            $ticket->timelines()->create($input);
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
        $input['status_id'] = TicketStatus::where("key", "waiting_for_access")->first()->id;
        $input['updated_by_id'] = Auth::id();

        if ($this->update($input)) {
            $input['created_by_id'] = Auth::id();
            $this->timelines()->create($input);

            try {
                $this->teamleader->notify(new TicketAssigned($this));
            } catch (\Throwable $th) {
                //throw $th;
            }
            // \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('NewTicketOpened', $this);
            return $this;
        }
    }

    public function receive($input)
    {
        
        if(isset($input['status_id'])) {
            $input['status_id'] = $input['status_id'];

        }
        else {
            if(isset($input['is_need_spare']) && $input['is_need_spare']) {
                if($this->type == 'breakdown')
                    $input['status_id'] = TicketStatus::where("key", "closed")->first()->id;
                else
                    $input['status_id'] = TicketStatus::where("key", "waiting_for_spare_parts")->first()->id;
            }
            else {
                if($this->type == 'breakdown')
                    $input['status_id'] = TicketStatus::where("key", "closed")->first()->id;
                else
                    $input['status_id'] = TicketStatus::where("key", "waiting_for_client_approval")->first()->id;
            }
        }
        $input['updated_by_id'] = Auth::id();
        if($this->update([
            'status_id' => $input['status_id'],
            'updated_by_id' => $input['updated_by_id'],
        ])) {
            $input['created_by_id'] = Auth::id();
            $this->timelines()->create($input);

            $process = $this->maintenance_processes()->create($input);
            if ($process) {
                foreach ($input['details'] as $item) {
                    $process->details()->create($item);
                }
            }

            try {
                // $users = User::supervisors()->merge(User::clients());
                // foreach ($users as $key => $value) {
                //     if($value->id == Auth::id())
                //         $users->forget($key);
                // }
                // Notification::send($users, new TicketClosed($this));
            } catch (\Throwable $th) {
                //throw $th;
            }
            return $this;
        }
    }
    
    public function close($input)
    {
        if(isset($input['is_reversed']) && $input['is_reversed'])
            $input['status_id'] = TicketStatus::where("key", "pending")->first()->id;
        else
            $input['status_id'] = TicketStatus::where("key", "closed")->first()->id;
        $input['updated_by_id'] = Auth::id();

        if ($this->update($input)) {
            $input['created_by_id'] = Auth::id();
            $this->timelines()->create($input);

            try {
                $users = User::supervisors()->merge(User::clients());
                foreach ($users as $key => $value) {
                    if($value->id == Auth::id())
                        $users->forget($key);
                }
                Notification::send($users, new TicketClosed($this));
            } catch (\Throwable $th) {
                //throw $th;
            }
            // \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('NewTicketOpened', $this);
            return $this;
        }
    }
}
