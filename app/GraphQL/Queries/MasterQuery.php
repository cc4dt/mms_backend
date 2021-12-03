<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use App\Models\Ticket;
use App\Models\MasterEquipment;
use App\Models\Part;
use App\Models\Equipment;

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
