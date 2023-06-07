<?php

use Maatwebsite\Excel\Facades\Excel;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\Models\IncidentReport;
use App\Models\EquipmentDetail;
use App\Models\Equipment;
use App\Http\Controllers\Users\PagesController;
use App\Http\Controllers\Office\OfficeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Municipality\MunicipalityController;
use App\Http\Controllers\Municipality\EquipmentController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Controllers\Borrow\BorrowingController;
use App\Http\Controllers\Borrow\BorrowHistoryController;
use App\Http\Controllers\Borrow\BDController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Exports\IncidentExport;
use App\Models\Office;

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


Route::get('api/municipalities/{province}', [MunicipalityController::class, 'allMuniciplity']);
Route::get('/Sorry', function () {
    return inertia('Error/MustVerify');
});


require __DIR__ . '/auth.php';




Route::group(['middleware' => ['auth', 'isSetup']], function () {

    
    /* 
                                                    !! START SHARED ENDPOINTS !!
    */
    Route::resource('inventory', EquipmentController::class)->only('show');
    Route::get('/borrow-attrs/{id}', [BorrowingController::class, 'borrowAttrs']);
    Route::get('/archive', [IncidentReportController::class, 'archive']);
    Route::get('/incident/download/{id}', [IncidentReportController::class, 'downloadFile']);
    Route::resource('report', IncidentReportController::class);
  
    /* 
                                                    !! END SHARED ENDPOINTS !!
    */


    /* 
                                                    !! START MUNICIPALITY ENDPOINTS !!
    */
    Route::group([
        'middleware' => 'role:RDRRMC_MUNICIPALITY',
        'prefix' => 'municipality',
        'as' => 'municipality.'
    ], function () {

        Route::resource('office', OfficeController::class)->only(['index']);
        Route::get('/incident/download/{id}', [IncidentReportController::class, 'downloadFile']);
        Route::resource('incident', IncidentReportController::class)->only(['index', 'store', 'update']);
        Route::get('/request', [PagesController::class, 'index']);
        Route::get('/approval', [PagesController::class, 'approval']);
        Route::resource('detail', BDController::class)->only(['update']);
        Route::resource('inventory', EquipmentController::class)->except('show');
        Route::resource('transaction', BorrowingController::class);
        Route::resource('history', BorrowHistoryController::class);
        Route::get('/partials', [BorrowingController::class, 'partial']);
        Route::get('/partials/{id}', [BorrowingController::class, 'showPartial']);
        Route::get('/request/{id}', [PagesController::class, 'show'])->name('shows');
        Route::post('/new-incident', [IncidentReportController::class, 'newIncident']);
    });
    /* 
                                                    !! END MUNICIPALITY ENDPOINTS !!
    */



    /* 
                                                    !! START PROVINCE ENDPOINTS !!
    */
    Route::group(['middleware' => 'role:RDRRMC_PROVINCE', 'prefix' => 'province', 'as' => 'province.'], function () {


        Route::get('/dashboard', [App\Http\Controllers\Province\PagesController::class, 'dashboard'])->name('dashboard');

        Route::get('/consolidated', [App\Http\Controllers\Province\PagesController::class, 'consolidated'])->name('consolidated');

        Route::get('/consolidatedShow/{id}', [App\Http\Controllers\Province\PagesController::class, 'consolidatedShow']);
        
        Route::get('/transaction', [App\Http\Controllers\Province\PagesController::class, 'transaction'])->name('transaction');

        Route::get('/archive', [App\Http\Controllers\Province\PagesController::class, 'archive']);
        
      
        Route::post('/incident', [IncidentReportController::class, 'request']);
        Route::resource('incident', IncidentReportController::class)->only('destroy');
    });
    /* 
                                                    !! END PROVINCE ENDPOINTS !!
    */

    /* 
                                                    !! START RDRRMC ENDPOINTS !!
    */
    Route::group(['middleware' => 'role:RDRRMC', 'prefix' => 'rdrrmc', 'as' => 'rdrrmc.'], function () {

        Route::get('/equipment-requests', [AdminPageController::class, 'transaction'])->name('transaction');

        Route::get('/dashboard', [AdminPageController::class, 'dashboard'])->name('dashboard');
        Route::resource('consolidated', AdminInventoryController::class)->only(['index', 'show']);
        // Route::get('/consolidated/equipment', [AdminPageController::class, 'consolidated'])->name('consolidated');
        Route::get('/register', [OfficeController::class, 'create'])->name('register');
        Route::get('/register/province', [OfficeController::class, 'create_province'])->name('register_province');
        Route::get('/municipalities', [OfficeController::class, 'municipality'])->name('municipalities');
        Route::get('/provinces', [OfficeController::class, 'province'])->name('provinces');
        Route::get('/archive', [AdminPageController::class, 'archive'])->name('archive');
        Route::get('/report/download/{id}', [IncidentReportController::class, 'downloadFile'])->name('download');
        Route::resource('office', OfficeController::class)->only(['edit', 'update']);
        Route::resource('report', IncidentReportController::class)->only('show');
    });

    /* 
                                                    !! END PROVINCE ENDPOINTS !!
    */

    /* 
                                                    !! START API ENDPOINTS !!
    */
    Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
        Route::post('/equipment', [EquipmentController::class, 'municipalityList']);
        Route::post('/cross/equipment/{name}', [EquipmentController::class, 'CrossMunicipalityList']);
        Route::post('/equipmentAttr', [EquipmentController::class, 'equipmentAttr'])->name('attrs');
       
        Route::post('/request', [BorrowingController::class, 'singleRequest']);
        Route::post('/new-request', [BorrowingController::class, 'updateRequest']);
        Route::post('/accepted/{id}', [BDController::class, 'accepted']);
        Route::post('/deny/{id}', [BDController::class, 'deny']);
        Route::get('/requestEquip/{id}', [BorrowingController::class, 'fetchEquip']);
        Route::put('/partials/{id}', [BorrowingController::class, 'UpdatePartial']);
        Route::post('/confirm-quantity', [BorrowingController::class, 'confirmQuantity']);
        Route::get('/invoice-data', [EquipmentController::class, 'invoice']);
       
 
        Route::get('/notification/request', [NotificationController::class, 'requestNotif']);

        Route::get('/notification/reconfirm', [NotificationController::class, 'reconfirmNotif']);

        Route::post(
            '/verify/{id}',
            function ($id) {
                Office::find($id)->update([
                    'must_reset_password' => 0,
                ]);

                return back();
        }
        );
        Route::post(
            '/unverify/{id}',
            function ($id) {
                Office::find($id)->delete();
        }
        );

        Route::get('/recents/{id}', function ($id) {

            return DB::table('approvals')
                ->select(
                   'ao.municipality as owner_municipality',
                   'aob.municipality as borrowee_municipality',
                   'approvals.created_at'
                )
                ->join('borrowings', 'borrowings.approval_id', '=', 'approvals.id')
                ->join('offices as borrowee', DB::raw('borrowee.id'), '=', 'approvals.borrowee')
                ->join('assign_offices as aob', DB::raw('aob.id'), '=', DB::raw('borrowee.assign'))
                ->join('offices as owner', DB::raw('owner.id'), '=', 'borrowings.owner')
                ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('owner.assign'))
                ->latest()->where('approvals.created_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->limit(3)->get();

        }
        );
        Route::get('/export/incident', function ($id) {
            return Excel::download(new IncidentExport($id), 'Incident-Report.xlsx');
         }
        );
        Route::get('/add-quantity/{id}', function (Request $request, $id) {
            $detail = EquipmentDetail::find($id);
                // dd($detail, $request->serviceable, $id);
            $detail->serviceable += $request->serviceable;
            $detail->poor += $request->poor;
            $detail->unusable += $request->unusable;
            $detail->save();

                return back();
        }
        );
    });
    /* 
                                                    !! END API ENDPOINTS !!
    */

    Route::get('/viewFile', function () {
        // return Excel::download(new InventorySummary, 'users.xlsx');
        return view('export.invoice', [
            'invoices' => Equipment::select([
                'equipment.name',
                'equipment_attributes.*',
                'equipment_details.serviceable',
                'equipment_details.poor',
                'equipment_details.unusable'
            ])

                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_owneds.equipment_attrs')
                ->where('equipment_owneds.office_id', auth()->id())->latest()
                ->get(),
            'office' => auth()->user(),
            'date' => Carbon::now()->format('F d Y ')

        ]);
        $sheet = 6;
        $q = DB::table('equipment')->select([
            'equipment.name',
            'equipment_attributes.*'
        ])->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
            ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
            ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_owneds.equipment_attrs')
            ->where('equipment_owneds.office_id', auth()->id())->latest()
            ->get()->filter(function ($e, $k) use ($sheet) {
                $sheet++;
                dd($e, $k);
            });

        dd($q, $sheet);
        $ge = new Collection();

        for ($i = 0; $i < $q->count(); $i++) {

            $ge->push($q[$i]);
            $ge->push($sheet);
            $sheet++;
        }
        return $ge;
        return Equipment::find('97e16919-e8ca-433d-ba52-8a98b5381ad4')->with(['equipment_owned' => function ($q) {
            $q->with('equipment_attribute')->first();
        }])->first();

        $report = IncidentReport::findOrFail('97be6896-5b89-4171-b0e8-0a96bf97c388');
        $headers = array(
            'Content-Type: application/pdf',
        );
        $cut = ltrim($report->file_path, "public/");
        $path = "../public/storage/" . $cut;

        return response()->file('../public/storage/xJS1r89ziM1SkL7il4JG2C1Dnc8EqOEdRb1rFXMr.pdf',  $headers);
    });
});
