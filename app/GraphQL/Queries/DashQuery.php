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
        return (object) [
            "sla" => [
                (object) ["key" => "in", "name" => "IN SLA", "count" => 62, "percentage" => 99.0],
                (object) ["key" => "out", "name" => "OUT SLA", "count" => 1, "percentage" => 1.0]
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
        return [
            (object) ["key" => "in", "name" => "IN SLA", "count" => 62, "percentage" => 99.0],
            (object) ["key" => "out", "name" => "OUT SLA", "count" => 1, "percentage" => 1.0]
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
