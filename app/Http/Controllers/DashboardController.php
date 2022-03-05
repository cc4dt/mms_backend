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
                "percent" => Ticket::whereTime('created_at', '>=', '16:00:00')->count() / Ticket::count() * 100
            ],
            "ticketStatusCounts" => TicketStatus::all()
                ->transform(function ($item) {
                    $count =Ticket::onStatus($item->key)->count();
                    return [
                        'key' => $item->name,
                        'data' => $count,
                        'percent' => $count / Ticket::count() * 100,
                    ];
                })
        ]);
    }
}
