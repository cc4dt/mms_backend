<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Ability;

class AbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            [
                "name" => Ticket::BROWSE,
                "label" => "Browse ticket",
            ],
            [
                "name" => Ticket::CREATE,
                "label" => "Open ticket",
            ],
            [
                "name" => Ticket::CREATE_CLIENT_SIDE,
                "label" => "Open client ticket",
            ],
            [
                "name" => Ticket::READ,
                "label" => "Read ticket",
            ],
            [
                "name" => Ticket::UPDATE,
                "label" => "Update ticket",
            ],
            [
                "name" => Ticket::DELETE,
                "label" => "Delete ticket",
            ],
            [
                "name" => Ticket::ASSIGN,
                "label" => "Assign ticket",
            ],
            [
                "name" => Ticket::CLIENT_ASSIGN,
                "label" => "Client assign ticket",
            ],
            [
                "name" => Ticket::RECEIVE,
                "label" => "Recevie ticket",
            ],
            [
                "name" => Ticket::CLIENT_RECEIVE,
                "label" => "Recevie client ticket",
            ],
            [
                "name" => Ticket::CANCEL,
                "label" => "Cancel ticket",
            ],
            [
                "name" => Ticket::CLIENT_CANCEL,
                "label" => "Cancel client ticket",
            ],
            [
                "name" => Ticket::APPROVAL,
                "label" => "Approval ticket",
            ],
            [
                "name" => Ticket::CLIENT_APPROVAL,
                "label" => "Approval client ticket",
            ],
            [
                "name" => Ticket::CLIENT_FEEDBACK,
                "label" => "Client feedback ticket",
            ],
        ];
        Ability::insert($abilities);
    }
}
