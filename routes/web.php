<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Services\MustApproved;
use App\Models\IncidentReport;
use App\Models\BorrowingDetails;
use App\Http\Controllers\Users\PagesController;
use App\Http\Controllers\Transactions\MunicipalityTransactionController;
use App\Http\Controllers\Province\ProvinceController;
use App\Http\Controllers\Office\OfficeController;
use App\Http\Controllers\Municipality\MunicipalityController;
use App\Http\Controllers\Municipality\EquipmentController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Controllers\Borrow\BorrowingController;
use App\Http\Controllers\Borrow\BorrowHistoryController;
use App\Http\Controllers\Borrow\BDController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Events\NewEquipmentAdded;
use App\Services\HistoryService;

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
    return Inertia::render('LandingPage');
})->name('landingPage')->middleware('guest');


require __DIR__ . '/auth.php';

Route::group(['middleware' => ['auth', 'isSetup']], function () {

//    Route::get('/history', function(HistoryService $history){
//     return dd(
//         BorrowingDetails::get()->map(function($q)=)
//     );
//    });

    Route::group([
        'middleware' => 'role:RDRRMC_MUNICIPALITY',
        'prefix' => 'municipality',
        'as' => 'municipality.'
    ], function () {
        
        Route::resource('office', OfficeController::class)->only(['index']);
        Route::get('/incident/download/{id}', [IncidentReportController::class, 'downloadFile']);
        Route::resource('incident', IncidentReportController::class)->only(['index','store', 'update']);
        Route::get('/request', [PagesController::class, 'index']);
        Route::get('/approval', [PagesController::class, 'approval']);
        Route::resource('detail', BDController::class)->only(['update']);
        Route::resource('inventory', EquipmentController::class);
        Route::resource('transaction', BorrowingController::class);
        Route::resource('history', BorrowHistoryController::class);
    });



   

    Route::group(['middleware' => 'role:RDRRMC_PROVINCE', 'prefix' => 'province', 'as' => 'province.'], function () {


        Route::get('/dashboard', [App\Http\Controllers\Province\PagesController::class, 'dashboard'])->name('dashboard');
        Route::get('/consolidated', [App\Http\Controllers\Province\PagesController::class, 'consolidated'])->name('consolidated');
        Route::get('/transaction', [App\Http\Controllers\Province\PagesController::class, 'transaction'])->name('transaction');
        // Route::get('/request', [App\Http\Controllers\Province\PagesController::class, 'request'])->name('request');
        Route::post('/incident', [IncidentReportController::class, 'request']);
    });

    Route::group(['middleware' => 'role:RDRRMC', 'prefix' => 'rdrrmc', 'as' => 'rdrrmc.'], function () {

        Route::get('/equipment-requests', [AdminPageController::class, 'transaction'])->name('transaction');
        Route::get('/dashboard', [AdminPageController::class, 'dashboard'])->name('dashboard');
        Route::get('/consolidated/equipment', [AdminPageController::class, 'consolidated'])->name('consolidated');
        Route::get('/register', [OfficeController::class, 'create'])->name('register');
        Route::get('/register/province', [OfficeController::class, 'create_province'])->name('register_province');
        Route::get('/municipalities', [OfficeController::class, 'municipality'])->name('municipalities');
        Route::get('/provinces', [OfficeController::class, 'province'])->name('provinces');
        Route::get('/reports', [AdminPageController::class, 'report'])->name('report');
        Route::get('/report/download/{id}', [IncidentReportController::class, 'downloadFile'])->name('download');
        Route::resource('office', OfficeController::class)->only(['edit','update']);
        Route::resource('report',IncidentReportController::class)->only('show');
        
    });

    Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
        Route::post('/equipment', [EquipmentController::class, 'municipalityList']);
        Route::post('/cross/equipment/{name}', [EquipmentController::class, 'CrossMunicipalityList']);
        Route::post('/equipmentAttr', [EquipmentController::class, 'equipmentAttr'])->name('attrs');
        Route::get('/municipality/notification/count', [BorrowingController::class, 'notif']);
        Route::post('/request', [BorrowingController::class, 'singleRequest']);
        Route::post('/accepted', [BDController::class, 'accepted']);
        Route::post('/deny', [BDController::class, 'deny']);
        Route::post('/requestAll', [BorrowingController::class, 'requestAll']);
    });
    
    Route::get('/viewFile', function () {
        $report = IncidentReport::findOrFail('97be6896-5b89-4171-b0e8-0a96bf97c388');
        $headers = array(
            'Content-Type: application/pdf',
        );
        $cut = ltrim($report->file_path,"public/");
        $path = "../public/storage/" . $cut;
       
        return response()->file('../public/storage/xJS1r89ziM1SkL7il4JG2C1Dnc8EqOEdRb1rFXMr.pdf',  $headers);
    });
});
