<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                "name" => User::ADMIN,
                "label" => "Admin",
            ],
            [
                "name" => User::SUPERVISORE,
                "label" => "Supervisor",
            ],
            [
                "name" => User::TEAMLEADER,
                "label" => "Teamleader",
            ],
            [
                "name" => User::DEALER,
                "label" => "Dealer",
            ],
            [
                "name" => User::SUPERCLIENT,
                "label" => "Super client",
            ],
            [
                "name" => User::CLIENT,
                "label" => "Client",
            ],
        ];

        Role::insert($roles);
    }
}
