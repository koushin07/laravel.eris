<?php

namespace App\Http\Controllers\Municipality;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Auth\Events\Validated;
use App\Services\EquipmentService;
use App\Models\User;
use App\Models\Municipality;
use App\Models\Equipment;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Controllers\Controller;
use App\Events\NewEquipmentAdded;
use App\Models\AssignOffice;
use App\Models\EquipmentOwned;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // Equipment::query()
        //     ->when(
        //         Request::input('search'),
        //         function ($q, $search) {
        //             $q->where('equipment_name', 'like', '%' . $search . '%');
        //         }
        //     )->when(
        //         Request::input('status'),
        //         function ($q, $status) {
        //             $q->where('status', 'like', '%' . $status . '%');
        //         }
        //     )->when(
        //         Request::input('owner'),
        //         function ($q, $owner) {
        //             $q->Where('municipality_id', auth()->user()->municipality_id);
        //         }
        //     )
        //     ->paginate(10)->onEachSide(1)->withQueryString(),
        // ->paginate(); 
        return inertia('Equipments', [
            'equipments' => DB::table('equipment')->select(
                [
                    'equipment.*',
                    'offices.name as owner',
                    'conditions.serviceable',
                    'conditions.unusable',
                    'conditions.poor',


                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('conditions', 'conditions.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->when(
                    Request::input('search'),
                    function ($q, $search) {
                        $q->where('equipment_name', 'like', '%' . $search . '%');
                    }
                )->when(
                    Request::input('owner'),
                    function ($q, $owner) {
                        $q->Where('equipment_owneds.office_id', $owner);
                    }
                )
                ->paginate()->onEachSide(1)->withQueryString(),

            'filters' => Request::only(['search', 'status', 'owner'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('yes');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEquipmentRequest $request, EquipmentService $equipmentService)
    {
        // dd($request);
        $request->validated();
        // $this->authorize('municipality');
        $equipmentService->insertData($request);
        NewEquipmentAdded::dispatch();
        return redirect('/equipment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        return inertia('Equipment', [
            'name' => AssignOffice::select('municipality')->find($id),
            'equipments' => DB::table('equipment')->select(
                [
                    'equipment.*',
                    'offices.name as owner',
                    'conditions.serviceable',
                    'conditions.unusable',
                    'conditions.poor',


                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('conditions', 'conditions.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->when(
                    Request::input('search'),
                    function ($q, $search) {
                        $q->where('equipment_name', 'like', '%' . $search . '%');
                    }
                )->Where('equipment_owneds.office_id', $id)
                ->paginate(10)->onEachSide(1)->withQueryString(),


            'filters' => Request::only(['search', 'status'])
        ]);
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $this->authorize('update-equipment', $equipment);
        $equipment->update($request->validated());
        return back()->with('success', 'Successfully Updated', 'yes');
    }

    public function getEquipment($name)
    {

        abort_unless(auth()->check(), 403);

        return EquipmentOwned::query()
            ->join('equipment', 'equipment_owneds.equipment_id', 'equipment.id')
            ->join('offices', 'offices.id','equipment_owneds.office_id')
            ->join('assign_offices', 'assign_offices.id', 'offices.assign')
            ->join('conditions', 'conditions.equipment_owner', 'equipment_owneds.id')
            ->where('assign_offices.municipality', $name)
            ->get();

        return Equipment::where([['municipality_id', '=', $id], ['status', '=', 'serviceable']])->get();
    }

    public function equipmentList($name)
    {
        abort_unless(auth()->check(), 403);

        return Equipment::where('equipment_name', '=', $name)->get();
    }
}
