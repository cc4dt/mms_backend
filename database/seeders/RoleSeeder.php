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
                "display_name" => "Admin",
            ],
            [
                "name" => User::SUPERVISORE,
                "display_name" => "Supervisor",
            ],
            [
                "name" => User::TEAMLEADER,
                "display_name" => "Teamleader",
            ],
            [
                "name" => User::DEALER,
                "display_name" => "Dealer",
            ],
            [
                "name" => User::SUPERCLIENT,
                "display_name" => "Super client",
            ],
            [
                "name" => User::CLIENT,
                "display_name" => "Client",
            ],
        ];

        Role::insert($roles);
    }
}
