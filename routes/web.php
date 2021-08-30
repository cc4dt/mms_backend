<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use App\User;
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