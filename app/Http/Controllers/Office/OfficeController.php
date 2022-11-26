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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return inertia('AccountPage', [
            'reports' =>  IncidentReport::where([
                ['reciever', auth()->id()],
                ['filename', null],
                ['file_path', null]
            ])->count(),
            'status' => DB::select(
                "SELECT
                SUM(serviceable + unusable + poor) AS total,
                        SUM(serviceable) AS serviceable,
                        SUM(unusable) AS unusable,
                        SUM(poor) AS poor
                      FROM equipment_details ed
                      JOIN equipment_owneds eo ON eo.id = ed.equipment_owner
                      JOIN offices o ON o.id = eo.office_id
                       WHERE o.id = :myid",
                [
                    'myid' => auth()->id(),
                ]
            )[0],
            'notification' => auth()->user()->unreadNotifications()->count(),
            'unfinish' => BorrowingDetails::where([
                ['borrowings.owner', auth()->id()],
                ['borrowing_details.equipment_attrs', null]
            ])
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('equipment', 'equipment.id', '=', 'borrowing_details.equipment_id')
                ->join('offices', 'offices.id', 'borrowings.borrower')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->count(),
            'updateReport' => IncidentReport::where('reciever', auth()->id())->get(),
            'equipments' => DB::table('equipment')->select(
                [
                    'equipment.name',
                    'equipment_attributes.*',
                    'offices.name as owner',
                    'equipment_details.serviceable',
                    'equipment_details.unusable',
                    'equipment_details.poor',
                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('equipment_attributes', 'equipment_attributes.equipment_id', '=', 'equipment.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->when(
                    $request->input('search'),
                    function ($q, $search) {
                        $q->where('equipment.name', 'like', '%' . $search . '%');
                    }
                )->where('equipment_owneds.office_id', auth()->id())
                ->paginate(5)->onEachSide(1)->withQueryString(),

            'filters' => $request->only(['search', 'status', 'owner'])

        ]);
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
        return redirect('/rdrrmc/dashboard');
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

        // ->join('equipment_owneds', 'equipment_owneds.office_id', '=', 'offices.id')
        // ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
        // ->whereNotNull('assign_offices.municipality')
        // ->whereNot('offices.name', 'RDRRMC')
        // ->groupBy('offices.id')
        //     ->when($request->input('search'), function ($q, $search) {
        //         $q->where('name', 'like', '%' . $search . '%');
        //     })
        //     ->paginate(10)->onEachSide(1)->withQueryString(),
        // 'filters' => $request->only(['search'])

        return inertia('Admin/MunicipalityPage', [
            'municipalities' => Office::select('offices.*', 'assign_offices.municipality', 'assign_offices.province',  DB::raw('count(equipment_owneds.id) as equipment'))

                ->leftJoin('equipment_owneds', 'equipment_owneds.office_id', '=', 'offices.id')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->whereNotNull('assign_offices.municipality')
                ->whereNot('offices.name', 'RDRRMC')
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
                    'offices.name',
                    'offices.email',
                    'offices.contact'
                )

                ->when($request->input('search'), function ($q, $search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10)->onEachSide(1)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }
}
