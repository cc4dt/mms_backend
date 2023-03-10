<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketOpened;
use App\Notifications\TicketClosed;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Gate;
use Log;

class Ticket extends Model
{
    const BROWSE = 'browse_ticket';
    const CREATE = 'create_ticket';
    const CREATE_CLIENT_SIDE = 'create_client_side_ticket';
    const READ = 'read_ticket';
    const UPDATE = 'update_ticket';
    const DELETE = 'delete_ticket';
    const ASSIGN = 'assgin_ticket';
    const CLIENT_ASSIGN = 'client_assgin_ticket';
    const RECEIVE = 'receive_ticket';
    const CLIENT_RECEIVE = 'receive_ticket';
    const CANCEL = 'cancel_ticket';
    const CLIENT_CANCEL = 'cancel_ticket';
    const APPROVAL = 'approval_ticket';
    const CLIENT_APPROVAL = 'approval_ticket';
    const CLIENT_FEEDBACK = 'client_feedback_ticket';

    // hours of
    const NORMAL = 72;
    const URGENT = 24;
    const EMERGENCY = 5;


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
        'client_side',
        'created_by_id',
        'updated_by_id',
    ];

    protected $appends = [
        'led_time',
        'timeout',
        'deadline',
        'sla',
        'in_sla',
        'actions',
        'by_client',
        'can_assign',
        'can_receive',
        'can_approval',
        'can_feedback',
        'can_cancel'
    ];

    protected $casts = [
        'client_side' => 'boolean',
    ];


    public function getCanAssignAttribute($value)
    {
        return Gate::allows('assgin', $this);
    }


    public function getCanReceiveAttribute($value)
    {
        return Gate::allows('receive', $this);
    }


    public function getCanApprovalAttribute($value)
    {
        return Gate::allows('approval', $this);
    }

    public function getCanFeedbackAttribute($value)
    {
        return Gate::allows('client-feedback', $this);
    }

    public function getCanCancelAttribute($value)
    {
        return Gate::allows('cancel', $this);
    }

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

    public function scopeToDay($query)
    {
        return $query->whereHas("openline", function ($q) {
            $q->whereDate('timestamp', Carbon::today())
                ->orderBy('timestamp', 'desc');
        });
    }

    public function scopeToMonth($query)
    {
        return $query->whereHas("openline", function ($q) {
            $q->whereYear('timestamp', Carbon::now()->year)
                ->whereMonth('timestamp', Carbon::now()->month)
                ->orderBy('timestamp', 'desc');
        });
    }

    static public function daily()
    {
        return Ticket::toDay()
            ->get();
    }

    static public function monthly()
    {
        return Ticket::toMonth()
            ->notOnStatus(TicketStatus::CANCELLED)
            ->notOnStatus(TicketStatus::CLOSED)
            ->get();
    }

    static public function scopeInSLA()
    {
        return Ticket::where(function ($qp) {
            $qp->where(function ($q) {
                $q->whereHas('priority',  function ($q) {
                    $q->where("key", "normal");
                });
                $q->whereHas('closeline', function ($q) {
                    $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, created_at) <= ?', [Ticket::NORMAL]);
                });
            })
                ->orWhere(function ($q) {
                    $q->whereHas('priority',  function ($q) {
                        $q->where("key", "urgent");
                    });
                    $q->whereHas('closeline', function ($q) {
                        $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, created_at) <= ?', [Ticket::URGENT]);
                    });
                })
                ->orWhere(function ($q) {
                    $q->whereHas('priority',  function ($q) {
                        $q->where("key", "emergency");
                    });
                    $q->whereHas('closeline', function ($q) {
                        $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, created_at) <= ?', [Ticket::EMERGENCY]);
                    });
                });
        });
    }

    static public function scopeOutSLA()
    {
        return Ticket::notOnStatus(TicketStatus::CANCELLED)->where(function ($qp) {
            $qp->where(function ($q) {
                $q->whereHas('priority',  function ($q) {
                    $q->where("key", "normal");
                });
                $q->where(function ($q) {
                    $q->whereHas('closeline', function ($q) {
                        $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, created_at) > ?', [Ticket::NORMAL]);
                    })
                        ->orWhere(function ($q) {
                            $q->doesntHave('closeline');
                            $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, now()) > ?', [Ticket::NORMAL]);
                        });
                });
            })
                ->orWhere(function ($q) {
                    $q->whereHas('priority',  function ($q) {
                        $q->where("key", "urgent");
                    });
                    $q->where(function ($q) {
                        $q->whereHas('closeline', function ($q) {
                            $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, created_at) > ?', [Ticket::URGENT]);
                        })
                            ->orWhere(function ($q) {
                                $q->doesntHave('closeline');
                                $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, now()) > ?', [Ticket::URGENT]);
                            });
                    });
                })
                ->orWhere(function ($q) {
                    $q->whereHas('priority',  function ($q) {
                        $q->where("key", "emergency");
                    });

                    $q->where(function ($q) {
                        $q->whereHas('closeline', function ($q) {
                            $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, created_at) > ?', [Ticket::EMERGENCY]);
                        })
                            ->orWhere(function ($q) {
                                $q->doesntHave('closeline');
                                $q->whereRaw('TIMESTAMPDIFF(HOUR, tickets.created_at, now()) > ?', [Ticket::EMERGENCY]);
                            });
                    });
                });
        });
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

    public function getTimeoutAttribute($value)
    {
        if($this->openline && $this->closeline)
            return $this->openline->timestamp->diffInSeconds($this->closeline->timestamp);
        else
            return 0;
    }

    public function getLedTimeAttribute($value)
    {
        foreach ($this->timelines as $value) {
            if ($value->status->key == 'waiting_for_client_approval' && $value->created_at) {
                $totalDuration = $this->created_at->diffInSeconds($value->created_at);
                return floor($totalDuration / 3600) . gmdate(":i", $totalDuration % 3600);
            } else if ($value->status->key == 'closed' && $value->created_at) {
                $totalDuration = $this->created_at->diffInSeconds($value->created_at);
                return floor($totalDuration / 3600) . gmdate(":i", $totalDuration % 3600);
            }
        }
    }

    public function getDeadlineAttribute($value)
    {
        if ($this->sla) {
            $deadline = $this->created_at->copy()->addHours($this->sla);
            if ($deadline >= Carbon::now())
                return $deadline;
        }
    }

    public function getSlaAttribute($value)
    {
        if ($this->priority) {
            if ($this->priority->key == "normal") {
                return Ticket::NORMAL;
            } elseif ($this->priority->key == "urgent") {
                return Ticket::URGENT;
            } elseif ($this->priority->key == "emergency") {
                return Ticket::EMERGENCY;
            }
        }
        return 0;
    }

    public function getInSlaAttribute($value)
    {
        return Ticket::inSla()->where('id', $this->id)->count() > 0;
        // foreach ($this->timelines as $value) {
        //     if($value->status->key == 'waiting_for_client_approval' && $value->created_at) {
        //         $hours = $this->created_at->diffInHours($value->created_at);
        //         if ($this->sla && $hours <= $this->sla) {
        //             return true;
        //         }
        //     }
        //     else if($value->status->key == 'closed' && $value->created_at) {
        //         $hours = $this->created_at->diffInHours($value->created_at);
        //         if ($this->sla && $hours <= $this->sla) {
        //             return true;
        //         }
        //     }
        // }
        return false;
    }

    public function getActionsAttribute($value)
    {
        $actions = [];
        try {
            foreach ($this->maintenance_processes as $process) {
                foreach ($process->details as $detail) {
                    if ($detail->procedure && $detail->procedure->type->key != "other")
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
        if (in_array($this->created_by->level->key, ['dealer', 'client']))
            return true;
        return false;
    }

    public function scopeOnType($query, $type)
    {
        if (!$type)
            return $query;
        return $query->whereHas('type', function ($query) use ($type) {
            $query->where('key', $type);
        })->orDoesntHave('type');
    }

    public function scopeHasStatus($query, $status)
    {
        if ($status)
            return $query->whereHas('timelines', function ($q) use ($status) {
                $q->whereHas('status', function ($q) use ($status) {
                    $q->where('key', $status);
                });
            });
    }

    public function scopeNotHasStatus($query, $status)
    {
        if ($status)
            return $query->whereHas('timelines', function ($q) use ($status) {
                $q->whereHas('status', function ($q) use ($status) {
                    $q->where('key', $status);
                });
            });
    }

    public function scopeOnStatus($query, $status)
    {
        if ($status)
            return $query->whereHas('timelines', function ($query) use ($status) {
                $query
                    ->whereHas('status', function ($query) use ($status) {
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

    public function scopeNotOnStatus($query, $status)
    {
        if ($status)
            return $query->whereHas('timelines', function ($query) use ($status) {
                $query
                    ->whereHas('status', function ($query) use ($status) {
                        $query->where('key', '!=', $status);
                    })
                    ->whereIn('id', function ($query) {
                        $query
                            ->selectRaw('max(id)')
                            ->from('ticket_timelines')
                            ->whereColumn('ticket_id', 'tickets.id');
                    });
            });
    }

    public function isOnStatus($status)
    {
        $key = $this->timeline->status->key;
        if (is_array($status))
            return in_array($key, $status);
        return $key = $status;
    }

    public function isHasStatus($status)
    {
        return $this->timelines()->hasStatus($status)->count() > 1;
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

        if ($ticket) {
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
        if (isset($input['status_id'])) {
            $input['status_id'] = $input['status_id'];
        } else {
            if (isset($input['is_need_spare']) && $input['is_need_spare']) {
                if ($this->type == 'breakdown')
                    $input['status_id'] = TicketStatus::where("key", "closed")->first()->id;
                else
                    $input['status_id'] = TicketStatus::where("key", "waiting_for_spare_parts")->first()->id;
            } else {
                if ($this->type == 'breakdown')
                    $input['status_id'] = TicketStatus::where("key", "closed")->first()->id;
                else
                    $input['status_id'] = TicketStatus::where("key", "waiting_for_client_approval")->first()->id;
            }
        }
        $input['updated_by_id'] = Auth::id();
        if ($this->update($input)) {
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
                    ->where(function ($q) {
                        $q->where(fn ($q) => $q->supervisors())
                            ->orWhere(fn ($q) => $q->clients())
                            ->orWhere(fn ($q) => $q->dealers());
                    })
                    ->get();

                if ((TicketStatus::find($input['status_id'])->key) == "closed") {
                    Notification::send($users, new TicketClosed($this));
                } elseif (TicketStatus::find($input['status_id'])->key == "waiting_for_client_approval") {
                    Notification::send($users, new TicketReceived($this));
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
            return $this;
        }
    }

    public function client_approval($input)
    {
        if (isset($input['is_reversed']) && $input['is_reversed'])
            $input['status_id'] = TicketStatus::where("key", "client_reversed")->first()->id;
        else
            $input['status_id'] = TicketStatus::where("key", "client_approved")->first()->id;
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
