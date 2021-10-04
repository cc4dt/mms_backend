<?php

namespace App\GraphQL\Queries;

use App\User;
use App\Ticket;
use App\MasterEquipment;
use App\Part;
use App\Equipment;

class MasterQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function ticketStatus($_, array $args)
    {
        return Ticket::ticketStatus();
    }

    public function ticketTypes($_, array $args)
    {
        return Ticket::types();
    }

    public function ticketTrades($_, array $args)
    {
        return Ticket::trades();
    }

    public function ticketPriorities($_, array $args)
    {
        return Ticket::priorities();
    }

    public function userLevels($_, array $args)
    {
        return User::levels();
    }

    public function masterEquipment($_, array $args)
    {
        if (array_key_exists('id', $args)) {
            return MasterEquipment::where("equipment_id", $args["id"])->get();
        }
        return MasterEquipment::all();
    }

    public function parts($_, array $args)
    {
        if (array_key_exists('id', $args)) {
            return Equipment::find($args["id"])->parts;
        }
        return Part::all();
    }

    public function part($_, array $args)
    {
        if (array_key_exists('id', $args)) {
            return Part::find($args["id"]);
        }
    }    
}
