<?php

namespace App\Http\Controllers\Office;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UnfinishTransaction;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\BorrowingDetails;
use App\Http\Controllers\Controller;
use App\Models\AssignOffice;
use App\Models\Role;

class OfficeController extends Controller
{
   
    public function index(Request $request)
    {

        return inertia('AccountPage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/CreateMunicipalityPage', [
            'provinces' => AssignOffice::whereNull('municipality')->whereNotNull('province')->get()
        ]);
    }
    public function create_province()
    {
        return inertia('Admin/CreateProvincePage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {

        return inertia('Admin/UpdateOfficePage', [
            'office' => $office,
            'provinces' => AssignOffice::with('office')->whereNull('municipality')->whereNotNull('province')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        $assign = AssignOffice::find($office->assign);

        $assign->update($request->all());
        return redirect('/rdrrmc/municipalities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }

    public function municipality(Request $request)
    {
        // Office::
        // select('offices.*', 'assign_offices.province', DB::raw('count(equipment_owneds.id) as equipment'))


        return inertia('Admin/MunicipalityPage', [
            'municipalities' => Office::select('offices.*', 'assign_offices.municipality', 'assign_offices.province',  DB::raw('count(equipment_owneds.id) as equipment'))

                ->leftJoin('equipment_owneds', 'equipment_owneds.office_id', '=', 'offices.id')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->whereNotNull('assign_offices.municipality')
                ->whereNotNull('assign_offices.municipality')
                ->whereNotNull('assign_offices.province')
                ->where('assign_offices.is_rdrrmc', false)
                ->groupBy('offices.id')
                ->when($request->input('search'), function ($q, $search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10)->onEachSide(1)->withQueryString(),
            'filters' => $request->only(['search']),
            'provinces' => AssignOffice::whereNull('municipality')->whereNotNull('province')->get()

        ]);
    }
    public function province(Request $request)
    {

        //    dd(
        //     Office::join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
        //         ->select( 'offices.name')
        //         ->join('roles', 'roles.id', 'offices.role_id')
        //         ->where('roles.role_type', Role::PROVINCE)
        //             ->when($request->input('search'), function ($q, $search) {
        //                 $q->where('name', 'like', '%' . $search . '%');
        //             })
        //             ->get() 
        //    );
        return inertia('Admin/ProvincePage', [
            'provinces' => Office::join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('roles', 'roles.id', 'offices.role_id')
                ->where('roles.role_type', Role::PROVINCE)
                ->select(
                    'assign_offices.province',
                    'offices.*',
                    
                )

                ->when($request->input('search'), function ($q, $search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10)->onEachSide(1)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    public function profile(){

    }
}
