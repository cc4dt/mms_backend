<?php

namespace App\GraphQL\Queries;

use App\Breakdown;
use App\Station;
use App\Ticket;

class DashQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $total = Ticket::inSLA()->count() + Ticket::outSLA()->count();
        return (object) [
            "sla" => [
                (object) ["key" => "in", "name" => "IN SLA", "count" => Ticket::inSLA()->count(), "percentage" => Ticket::inSLA()->count() / $total * 100],
                (object) ["key" => "out", "name" => "OUT SLA", "count" => Ticket::outSLA()->count(), "percentage" => Ticket::outSLA()->count() / $total * 100]
            ],
            "topReported" => Breakdown::all()
                ->sortByDesc(function ($item, $key) {
                    return $item->topCount;
                })
                ->values()
                ->take(3)
                ->all(),
            "topReportedStation" => Station::all()
                ->sortByDesc(function ($item, $key) {
                    return $item->topCount;
                })
                ->values()
                ->take(3)
                ->all(),
            "statusReported" => Ticket::statusReported(),
        ];
    }
    
    public function sla($_, array $args)
    {
        $total = Ticket::inSLA()->count() + Ticket::outSLA()->count();
        return [
            (object) ["key" => "in", "name" => "IN SLA", "count" => Ticket::inSLA()->count(), "percentage" => Ticket::inSLA()->count() / $total * 100],
            (object) ["key" => "out", "name" => "OUT SLA", "count" => Ticket::outSLA()->count(), "percentage" => Ticket::outSLA()->count() / $total * 100]
        ];
    }
    
    public function topReported($_, array $args)
    {
        return Breakdown::all()
        ->sortByDesc(function ($item, $key) {
            return $item->topCount;
        })
        ->values()
        ->take(3)
        ->all();
    }
    
    public function topReportedStation($_, array $args)
    {
        return Station::all()
        ->sortByDesc(function ($item, $key) {
            return $item->topCount;
        })
        ->values()
        ->take(3)
        ->all();
    }
    
    public function statusReported($_, array $args)
    {   
        return Ticket::statusReported();
    }
}
