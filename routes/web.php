<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use App\User;
use App\Ticket;
use App\Part;
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
    // var_dump(Ticket::toDay());
    // var_dump(Ticket::daily());
    foreach (Ticket::monthly() as $value) {
        var_dump($value->number);
    }
    // return $user->notifications->first()->data;
});


Auth::routes();
Route::resource('/Client', 'ClientController')->middleware('auth');
Route::resource('/Admin', 'AdminController')->middleware('auth');
Route::resource('/Supervisor', 'SupervisorController')->middleware('auth');
Route::resource('/Teamleader', 'TeamleaderController')->middleware('auth');
Route::resource('/Report', 'ReportController')->middleware('auth');
Route::resource('/Dealer', 'DealerController')->middleware('auth');
Route::get('/ticket/{id}', 'TicketController@index')->middleware('auth')->name('ticket');
Route::get('/report/breakdown', 'ReportController@breakdown')->middleware('auth')->name('breakdown-report');
Route::get('/report/maintenance', 'ReportController@maintenance')->middleware('auth')->name('maintenance-report');
Route::get('/report/pm', 'ReportController@pm')->middleware('auth')->name('pm-report');
Route::get('/home', 'HomeController@index')->middleware('auth')->name('Home');
Route::get('ajax_fetch_data/{table}/{id}','ajax_data\FetchController@getdata');