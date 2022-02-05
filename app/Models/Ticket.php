<?php

namespace App\Models;

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

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

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
        'by_client'
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
        return $this->belongsTo(User::class);
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function breakdown(): BelongsTo
    {
        return $this->belongsTo(Breakdown::class);
    }

    public function maintenance_processes(): HasMany
    {
        return $this->hasMany(MaintenanceProcess::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(TicketTimeline::class);
    }

    public function timeline(): HasOne
    {
        return $this->hasOne(TicketTimeline::class)->latest();
    }

    public function openline(): HasOne
    {
        return $this->hasOne(TicketTimeline::class)->whereHas('status',  function ($query) {
            $query->where('key', 'opened');
        });
    }

    public function closeline(): HasOne
    {
        return $this->hasOne(TicketTimeline::class)->whereHas('status',  function ($query) {
            $query->where('key', 'closed');
        });
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    public function trade(): BelongsTo
    {
        return $this->belongsTo(TicketTrade::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(TicketPriority::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class);
    }
    
    public function getLedTimeAttribute($value)
    {
        foreach ($this->timelines as $value) {
            if($value->status->key == 'waiting_for_client_approval' && $value->created_at) {
                $totalDuration = $this->created_at->diffInSeconds($value->created_at);
                return floor($totalDuration / 3600) . gmdate(":i", $totalDuration % 3600);
            }
            else if($value->status->key == 'closed' && $value->created_at) {
                $totalDuration = $this->created_at->diffInSeconds($value->created_at);
                return floor($totalDuration / 3600) . gmdate(":i", $totalDuration % 3600);
            }
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
    
    public function getInSlaAttribute($value)
    {
        foreach ($this->timelines as $value) {
            if($value->status->key == 'waiting_for_client_approval' && $value->created_at) {
                $hours = $this->created_at->diffInHours($value->created_at);
                if ($this->sla && $hours <= $this->sla) {
                    return true;
                }
            }
            else if($value->status->key == 'closed' && $value->created_at) {
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
        try {
            foreach ($this->maintenance_processes as $process) {
                foreach ($process->details as $detail) {
                    if($detail->procedure && $detail->procedure->type->key != "other")
                        $actions[] = $detail->procedure->name;
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $actions;
    }
    
    public function getByClientAttribute($value)
    {
        if(in_array($this->created_by->level->key, ['dealer', 'client']))
            return true;
        return false;
    }

    public function scopeOnType($query, $type)
    {
        if(!$type)
            return $query;
        return $query->whereHas('type', function ($query) use($type) {
            $query->where('key', $type);
        })->orDoesntHave('type');
    }
    
    public function scopeHasStatus($query, $status)
    {
        if(!$status)
            return $query;
        return $query->whereHas('timelines', function ($query) use($status) {
            $query->whereHas('status', function ($query) use($status) {
                $query->where('key', $status);
            });
        });
    }
    
    public function scopeOnStatus($query, $status)
    {
        if(!$status)
            return $query;
        return $query->whereHas('timelines', function ($query) use($status) {
            $query
                ->whereHas('status', function ($query) use($status) {
                    $query->where('key', $status);
                })
                ->whereIn('id', function ($query) {
                    $query
                        ->selectRaw('max(id)')
                        ->from('ticket_timelines')
                        ->whereColumn('ticket_id', 'tickets.id');
                });
        });
    }
    
    public function jobs($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Ticket::hasStatus('transfer_to_job');
    }

    static public function open($input)
    {
        if (isset($input['date']) && Auth::user()->isSupervisor()) {
            $input['timestamp'] = new Carbon($input['date']);
        } else {
            $input['timestamp'] = Carbon::now();
        }
        $input['number'] = Carbon::now()->timestamp;
        $input['status_id'] = TicketStatus::where("key", "opened")->first()->id;
        $input['created_by_id'] = Auth::id();
        $input['updated_by_id'] = Auth::id();
        $ticket = Ticket::create($input);

        if($ticket) {
            $ticket->timelines()->create($input);
            try {
                Notification::send(User::supervisors()->get(), new TicketOpened($ticket));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
            return $ticket;
        }
    }

    public function assign($input)
    {
        if (TicketType::find($input['type_id'])->key == "job") {
            $input['status_id'] = TicketStatus::where("key", "transfer_to_job")->first()->id;
        } else {
            $input['status_id'] = TicketStatus::where("key", "waiting_for_access")->first()->id;
        }
        $input['updated_by_id'] = Auth::id();

        if ($this->update($input)) {
            $input['created_by_id'] = Auth::id();
            $this->timelines()->create($input);

            try {
                $this->teamleader->notify(new TicketAssigned($this));
            } catch (Exception $e) {
                Log::error($e->getMessage());
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
        if($this->update($input)) {
            $input['created_by_id'] = Auth::id();
            $timeline = $this->timelines()->create($input);
            foreach ($input['processes'] as $processItem) {
                $processItem["ticket_id"] = $this->id;
                $process = $timeline->maintenance_processes()->create($processItem);
                if ($process) {
                    foreach ($processItem['details'] as $item) {
                        $process->details()->create($item);
                    }
                }
            }

            try {
                $users = User::where("id", "!=", Auth::id())
                    ->where(function($q) {
                        $q->orWhere(fn($q) => $q->supervisors())
                        ->orWhere(fn($q) => $q->clients())
                        ->orWhere(fn($q) => $q->dealers());
                    })
                    ->get();
                if(TicketStatus::find($input['status_id'])->key == "colsed")
                    Notification::send($users, new TicketClosed($this));
                elseif(TicketStatus::find($input['status_id'])->key == "waiting_for_client_approval")
                    Notification::send($users, new TicketReceived($this));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
            return $this;
        }
    }
    
    public function client_approval($input)
    {
        if(isset($input['is_reversed']) && $input['is_reversed'])
            $input['status_id'] = TicketStatus::where("key", "pending")->first()->id;
        else
            $input['status_id'] = TicketStatus::where("key", "waiting_for_approval")->first()->id;
        $input['updated_by_id'] = Auth::id();

        if ($this->update($input)) {
            $input['created_by_id'] = Auth::id();
            $this->timelines()->create($input);

            try {
                // $users = User::supervisors()->get()->merge(User::clients()->get());
                // foreach ($users as $key => $value) {
                //     if($value->id == Auth::id())
                //         $users->forget($key);
                // }
                // Notification::send(User::supervisors()->get(), new TicketClientFeedback($this));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
            // \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('NewTicketOpened', $this);
            return $this;
        }
    }
    
    public function approval($input)
    {
        $input['updated_by_id'] = Auth::id();

        if ($this->update($input)) {
            $input['created_by_id'] = Auth::id();
            $this->timelines()->create($input);

            try {
                // $users = User::supervisors()->get()->merge(User::clients()->get());
                // foreach ($users as $key => $value) {
                //     if($value->id == Auth::id())
                //         $users->forget($key);
                // }
                // Notification::send(User::supervisors()->get(), new TicketClosed($this));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
            // \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('NewTicketOpened', $this);
            return $this;
        }
    }
}
