<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\Breakdown;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            "openedToDay" => Ticket::daily()->loadMissing('station', 'type', 'timeline.status', 'openline.created_by', 'breakdown'),
            "openedToMonth" => Ticket::monthly()->loadMissing('station','type', 'timeline.status', 'openline.created_by', 'breakdown'),
            "slaCounts" => [
                [
                    'key' => "IN SERVICE",
                    'data' => Ticket::inSla()->count()
                ],
                [
                    'key' => "OUT SERVICE",
                    'data' => Ticket::outSla()->count()

                ]
            ],
            "stationBreakdownCounts" => Station::all()->transform(function ($item) {
                return [
                    'key' => $item->name,
                    // ->onType('breakdown')
                    'data' => $item->tickets()->count()
                ];
            }),
            "breakdownCounts" => Breakdown::all()
                ->transform(function ($item) {
                    return [
                        'key' => $item->name,
                        // ->onType('breakdown')
                        'data' => $item->tickets()->count()
                    ];
                }),
            "creatorCounts" => User::all()
                ->transform(function ($item) {
                    return [
                        'key' => $item->name,
                        'data' => Ticket::where('created_by_id', $item->id)->count()
                    ];
                }),
            "creatorAfter4pmCounts" => User::all()
                ->transform(function ($item) {
                    return [
                        'key' => $item->name,
                        'data' => Ticket::whereTime('created_at', '>=', '16:00:00')->where('created_by_id', $item->id)->count()
                    ];
                }),
            "colserAfter4pmCounts" => User::all()
                ->transform(function ($item) {
                    return [
                        'key' => $item->name,
                        'data' => Ticket::whereHas('closeline', function($q) use($item) {
                            $q->where('created_by_id', $item->id);
                        })->whereTime('created_at', '>=', '16:00:00')->count()
                    ];
                }),
            "colserCounts" => User::all()
                ->transform(function ($item) {
                    return [
                        'key' => $item->name,
                        'data' => Ticket::whereHas('closeline', function($q) use($item) {
                            $q->where('created_by_id', $item->id);
                        })->count()
                    ];
                }),
            "total" => [
                "tickets" => Ticket::count(),
            ],
            "over4pm" => [
                "count" => Ticket::whereTime('created_at', '>=', '16:00:00')->count(),
                "percent" => Ticket::whereTime('created_at', '>=', '16:00:00')->count() ? Ticket::whereTime('created_at', '>=', '16:00:00')->count() / Ticket::count() * 100 : 0
            ],
            "ticketStatusCounts" => TicketStatus::all()
                ->transform(function ($item) {
                    $count =Ticket::onStatus($item->key)->count();
                    return [
                        'key' => $item->name,
                        'data' => $count,
                        'percent' => $count ?  $count / Ticket::count() * 100 : 0,
                    ];
                })
        ]);
    }
}
