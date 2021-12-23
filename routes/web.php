<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BreakdownController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ajax_data\FetchController;

use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Part;
use App\Models\MaintenanceProcess;
use App\Models\MasterEquipment;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });



Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
    // Route::resource('users', UserController::class);
    Route::resource('hse', HseController::class);
    Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');
    Route::resource('/breakdown', BreakdownController::class)->middleware('auth');
    Route::resource('/link', LinkController::class)->middleware('auth');
    Route::resource('/Report', ReportController::class)->middleware('auth');
    Route::get('/report/breakdown', [ReportController::class, 'breakdown'])->middleware('auth')->name('breakdown-report');
    Route::get('/report/maintenance', [ReportController::class, 'maintenance'])->middleware('auth')->name('maintenance-report');
    Route::get('/report/pm', [ReportController::class, 'pm'])->middleware('auth')->name('pm-report');
    Route::get('/report/pm-fireexting', [ReportController::class, 'pm_fireexting'])->middleware('auth')->name('pm-fireexting-report');
    Route::get('ajax_fetch_data/{table}/{id}', [FetchController::class, 'getdata']);
    Route::get('/app/download', function () {
        return Inertia::render('App/Index');
    })->name('app.download');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
