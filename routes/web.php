<?php

use App\Events\NewEquipmentAdded;
use App\Http\Controllers\Borrow\BorrowingController;
use App\Http\Controllers\Municipality\EquipmentController;
use App\Http\Controllers\Municipality\MunicipalityController;
use App\Http\Controllers\Office\OfficeController;
use App\Http\Controllers\Province\ProvinceController;
use App\Http\Controllers\Transactions\MunicipalityTransactionController;
use App\Http\Controllers\Users\PagesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/landing', function () {
    return Inertia::render('LandingPage');
});

/* Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 */
require __DIR__ . '/auth.php';
Route::group(['middleware' => 'auth', 'verified'], function () {
    Route::get('/dashboard', [PagesController::class, 'index'])->name('dashboard');
    Route::resource('transactions', MunicipalityTransactionController::class);
    Route::resource('equipment', EquipmentController::class);

    Route::resource('borrowing', BorrowingController::class);
    Route::resource('office', OfficeController::class);
    Route::group(['middleware' => 'role:RDRRMC_PROVINCE', 'prefix' => 'province', 'as' => 'province.'], function () {


        Route::get('/dashboard', [App\Http\Controllers\Province\PagesController::class, 'dashboard'])->name('province_dashboard');
    });
});

Route::get('/distance', [PagesController::class, 'distance']);



Route::post('/api/accept/{id}', [BorrowingController::class, 'accept']);
Route::post('/api/deny/{id}', [BorrowingController::class, 'deny']);
Route::get('/provinces-Municipality/{id}', [MunicipalityController::class, 'allMuniciplity']);
Route::post('/getEquipment/{name}', [EquipmentController::class, 'getEquipment']);
Route::post('/equipmentList/{name}', [EquipmentController::class, 'equipmentList']);
Route::get('/api/send', [PagesController::class, 'send']);
Route::get('/api/pending', [PagesController::class, 'pending']);
Route::get('/api/returnedChart', [PagesController::class, 'returnedChart']);
