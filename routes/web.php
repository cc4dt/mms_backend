<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use App\User;
use App\Ticket;
use App\EquipmentPart;
use App\MaintenanceProcess;
use App\MasterEquipment;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/login', function () {
    return view('auth/login');
});

Route::get('/test', function () {
    // Ticket::first()->close([
    //     "equipment_id" => 1,
    //     "equipment_part_id" => 1,
    //     "details" => [
    //         [
    //             "equipment_sub_part_id" => 1,
    //             "attribute_id" => 1,
    //             "value" => "true",
    //         ]
    //     ]
    // ]);
    // print_r(Ticket::first());
    // print_r(EquipmentPart::first());
    // print_r(EquipmentPart::first()->subParts);
    // print_r(MasterEquipment::first());
    // print_r(MasterEquipment::first()->details);
    // print_r(Ticket::first()->maintenance_processes);
    // print_r(Ticket::first()->maintenance_processes[0]->details);
    $user = User::find(3);
    print_r($user->notifications->first()->data);
    var_dump($user->notifications->first()->data);
    return $user->notifications->first()->data;
});

Auth::routes();
Route::resource('Client', 'ClientController');
Route::get('/home', 'HomeController@index')->name('Home');
Route::get('home', 'HomeController@index')->name('Home');
//Route::get('/Clients', 'ClientController@index')->name('Client');
Route::get('/Supervisors', 'SupervisorController@index')->name('Supervisor');
Route::get('/Teamleaders', 'TeamleaderController@index')->name('Teamleader');
Route::get('/Admins', 'AdminController@index')->name('Admin');