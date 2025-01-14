<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BreakdownController;
use App\Http\Controllers\StationController;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\TicketController;

use App\Http\Controllers\ajax_data\FetchController;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;

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

    Route::get('/', DashboardController::class)->name('dashboard');

    // Route::resource('users', UserController::class);

    Route::get('ticket/export', [
        TicketController::class, 'export'
    ])->name('ticket.export.index');

    Route::get('report/ticket', [
        TicketController::class, 'report',
    ])->name('ticket.report');

    Route::resource('ticket', TicketController::class);
    
    Route::resource('station', StationController::class);
    Route::get('report/station/statement/{station}', [StationController::class, 'statementExport'])->name('station.report.statement');

    try {
        $categories = Category::all();
        foreach ($categories as $value) {
            Route::get('maintenance/' . $value->slug . '/export', [
                MaintenanceController::class, 'export'
            ])->name('maintenance.' . $value->slug . '.export.index');

            Route::get('maintenance/' . $value->slug . '/report-costs', [
                MaintenanceController::class, 'report_costs',
            ])->name('maintenance.' . $value->slug . '.report.costs');
            
            Route::get('report/' . $value->slug . '/needs', [
                MaintenanceController::class, 'maintenance_needs',
            ])->name('needs.' . $value->slug . '.report');

            Route::get('report/' . $value->slug . '/maintenance', [
                MaintenanceController::class, 'report',
            ])->name('maintenance.' . $value->slug . '.report');

            Route::get('maintenance/' . $value->slug . '/datatables', [
                MaintenanceController::class, 'datatables',
            ])->name('maintenance.' . $value->slug . '.datatables');

            Route::resource('maintenance/'.$value->slug, MaintenanceController::class, ["as" => "maintenance"])->parameters([$value->slug => 'maintenance']);
        }
    } catch (\Throwable $th) {
    }
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('breakdown', BreakdownController::class);
    Route::resource('link', LinkController::class);
    Route::resource('master', EquipmentController::class);


    Route::get('report/master/qrcode', [
        EquipmentController::class, 'exportQrcode',
    ])->name('qrcode.master.report');

    Route::resource('/Report', ReportController::class);

    Route::get('/report/breakdown', [ReportController::class, 'breakdown'])->name('breakdown-report');
    Route::get('/report/corrective', [ReportController::class, 'corrective'])->name('corrective-report');
    Route::get('/report/maintenance', [ReportController::class, 'maintenance'])->name('maintenance-report');
    Route::get('/report/pm', [ReportController::class, 'pm'])->name('pm-report');
    Route::get('/report/pm-fireexting', [ReportController::class, 'pm_fireexting'])->name('pm-fireexting-report');
    Route::get('/report/hse', [ReportController::class, 'hse'])->name('hse-report');
    Route::get('/report/off-working-hours', [ReportController::class, 'off_working_hours'])->name('off-working-hours-report');
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
