<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HseController;
use App\Http\Controllers\PmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BreakdownController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ajax_data\FetchController;

use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Part;
use App\Models\MaintenanceProcess;
use App\Models\MasterEquipment;
use App\Models\Category;
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



Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
    Route::resource('users', UsersController::class);
    Route::resource('users2', UserController::class);
    
    // Route::resource('hse', HseController::class);
    
    try {
        $categories = Category::all();
        foreach ($categories as $value) {
            Route::get('maintenance/' . $value->slug . '/datatables', [
                    MaintenanceController::class, 'datatables',
                ])->name('maintenance.' . $value->slug . '.datatables');
            Route::resource('maintenance/'.$value->slug, MaintenanceController::class, ["as" => "maintenance"])->parameters([$value->slug => 'maintenance']);
        }
    } catch (\Throwable $th) {
        throw $th;
    }
    Route::resource('pm', PmController::class);
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('/breakdown', BreakdownController::class);
    Route::resource('/link', LinkController::class);
    Route::resource('/Report', ReportController::class);
    
    Route::get('/report/breakdown', [ReportController::class, 'breakdown'])->name('breakdown-report');
    Route::get('/report/corrective', [ReportController::class, 'corrective'])->name('corrective-report');
    Route::get('/report/maintenance', [ReportController::class, 'maintenance'])->name('maintenance-report');
    Route::get('/report/pm', [ReportController::class, 'pm'])->name('pm-report');
    Route::get('/report/pm-fireexting', [ReportController::class, 'pm_fireexting'])->name('pm-fireexting-report');
    Route::get('/report/hse', [ReportController::class, 'hse'])->name('hse-report');
    Route::get('/report/hse-costs', [ReportController::class, 'hse_costs'])->name('hse-costs-report');
    Route::get('/report/hse-procedures', [ReportController::class, 'hse_procedures'])->name('hse-procedures-report');
    Route::get('ajax_fetch_data/{table}/{id}', [FetchController::class, 'getdata']);
    Route::get('/app', function () {
        return Inertia::render('App/Index', [
            'version' =>  setting('app.latest_app_version'),
        ]);
    })->name('app');
});

Route::get('/app/download/android', function () {
    if(setting('app.download')) {
        $file = json_decode(setting('app.download'))[0]->download_link;
        $path  = Storage::disk(config('voyager.storage.disk'))->path($file);
        return response()->download($path, 'MMS.apk');
    } else {
        return abort(404); 
    }
})->name('app.download.android');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
