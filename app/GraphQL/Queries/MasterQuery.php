<?php

namespace App\GraphQL\Queries;

use App\User;
use App\Ticket;

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
}