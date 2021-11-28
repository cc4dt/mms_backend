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
    
    // $timelines = Timeline::whereHas('status', function (Builder $query) {
    //     $query->where('key', 'transfer_to_job');
    // });

    $tickets = Ticket::whereHas('timelines', function ($query) {
        $query->whereHas('status', function ($query) {
            $query->where('key', 'transfer_to_job');
        });
    });
    echo $tickets->toRawSql() . "<br>";
    foreach ($tickets->get() as $value) {
        echo "id: ".$value->id."<br>";
    }
});


Auth::routes();
Route::resource('/breakdown', 'BreakdownController')->middleware('auth');
Route::resource('/link', 'LinkController')->middleware('auth');
Route::resource('/report', 'ReportController')->middleware('auth');
Route::get('/report/breakdown', 'ReportController@breakdown')->middleware('auth')->name('breakdown-report');
Route::get('/report/maintenance', 'ReportController@maintenance')->middleware('auth')->name('maintenance-report');
Route::get('/report/pm', 'ReportController@pm')->middleware('auth')->name('pm-report');
Route::get('/report/pm-fireexting', 'ReportController@pm_fireexting')->middleware('auth')->name('pm-fireexting-report');
Route::get('/home', 'HomeController@index')->middleware('auth')->name('Home');
Route::get('ajax_fetch_data/{table}/{id}','ajax_data\FetchController@getdata');