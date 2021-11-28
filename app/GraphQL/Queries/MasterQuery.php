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
    
    public function userLevels($_, array $args)
    {
        return User::levels();
    }
}
