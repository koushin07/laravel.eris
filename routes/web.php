<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Services\LocationService;
use App\Http\Controllers\Users\PagesController;
use App\Http\Controllers\Transactions\MunicipalityTransactionController;
use App\Http\Controllers\Province\ProvinceController;
use App\Http\Controllers\Office\OfficeController;
use App\Http\Controllers\Municipality\MunicipalityController;
use App\Http\Controllers\Municipality\EquipmentController;
use App\Http\Controllers\Borrow\UnfinishTransactionController;
use App\Http\Controllers\Borrow\BorrowingController;
use App\Http\Controllers\Borrow\BorrowHistoryController;
use App\Events\NewEquipmentAdded;
use App\Http\Controllers\IncidentReportController;

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
Route::get('/', function () {
    return Inertia::render('LandingPage');
})->name('landingPage');

/* Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 */
require __DIR__ . '/auth.php';
Route::group(['middleware' => 'auth', 'verified'], function () {

    Route::get('/upload', function () {
        return inertia('municipality/Fileupload');
    });

    Route::post('/uploading', function (Request $request) {
        $request->validate([

            'docs' => 'mimes:pdf,docx,docs|max:2048',
        ]);

        if ($request->hasFile('docs')) {
            $doc_path = $request->file('docs')->store('docs', 'public');
            dd($doc_path);
        }
        return;
        // return inertia('municipality/Fileupload');
    });
    Route::group([
        'middleware' => 'role:RDRRMC_MUNICIPALITY',
        'prefix' => 'municipality',
        'as' => 'municipality.'
    ], function () {
        Route::resource('office', OfficeController::class);

        Route::resource('incident', IncidentReportController::class)->only(['store']);
        Route::get('/request', [PagesController::class, 'index']);
        Route::resource('inventory', EquipmentController::class);
        Route::resource('transaction', BorrowingController::class);
        Route::resource('history', BorrowHistoryController::class);
    });



    Route::resource('borrowing', BorrowingController::class);
   

    Route::group(['middleware' => 'role:RDRRMC_PROVINCE', 'prefix' => 'province', 'as' => 'province.'], function () {


        Route::get('/dashboard', [App\Http\Controllers\Province\PagesController::class, 'dashboard'])->name('dashboard');
        Route::get('/consolidated', [App\Http\Controllers\Province\PagesController::class, 'consolidated'])->name('consolidated');
        Route::get('/transaction', [App\Http\Controllers\Province\PagesController::class, 'transaction'])->name('transaction');
        Route::get('/request', [App\Http\Controllers\Province\PagesController::class, 'request'])->name('request');
        Route::post('/incident', [IncidentReportController::class, 'request']);
        

    });

    Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
        Route::post('/equipment/{name}/quantity/{quantity}', [EquipmentController::class, 'municipalityList']);
        Route::post('/cross/equipment/{name}/quantity/{quantity}', [EquipmentController::class, 'CrossMunicipalityList']);
        Route::post('/equipmentAttr', [EquipmentController::class, 'equipmentAttr'])->name('attrs');
        Route::post('/{name}/request/{id}/{quantity}', [BorrowingController::class, 'singleRequest']);
        Route::post('/accepted', [UnfinishTransactionController::class, 'accepted']);
        Route::post('/deny', [UnfinishTransactionController::class, 'deny']);
        Route::post('/requestAll', [BorrowingController::class, 'requestAll']);
    });
});

Route::get('/distance', [PagesController::class, 'distance']);
