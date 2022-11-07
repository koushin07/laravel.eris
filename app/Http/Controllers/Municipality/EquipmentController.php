<?php

namespace App\Http\Controllers\Municipality;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Req;
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
use App\Services\LocationService;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{

    protected $equipmentService;


    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('municipality/InventoryPage', [
            'equipments' => DB::table('equipment')->select(
                [
                    'equipment.*',
                    'offices.name as owner',
                    'equipment_details.serviceable',
                    'equipment_details.unusable',
                    'equipment_details.poor',
                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->when(
                    Request::input('search'),
                    function ($q, $search) {
                        $q->where('equipment_name', 'like', '%' . $search . '%');
                    }
                )->where('equipment_owneds.office_id', auth()->id())
                ->paginate(5)->onEachSide(1)->withQueryString(),

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
        return inertia('municipality/FormPage');
    }


    public function store(CreateEquipmentRequest $request)
    {
        // dd($request);
        $request->validated();

        $this->equipmentService->insertData($request);
        // NewEquipmentAdded::dispatch();
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return inertia('municipality/InventoyPage', [
            'name' => AssignOffice::select('municipality')->find($id),
            'equipments' => DB::table('equipment')->select(
                [
                    'equipment.*',
                    'offices.name as owner',
                    'equipment_details.serviceable',
                    'equipment_details.unusable',
                    'equipment_details.poor',


                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->when(
                    Request::input('search'),
                    function ($q, $search) {
                        $q->where('equipment_name', 'like', '%' . $search . '%');
                    }
                )->Where('equipment_owneds.office_id', $id)
                ->paginate(2)->onEachSide(1)->withQueryString(),


            'filters' => Request::only(['search', 'status'])
        ]);
    }

    public function update(UpdateEquipmentRequest $request, $id)
    {
        $request->validated();
        $equipment = Equipment::find($id);
        $equipment->update([
            'equipment_name' => $request->equipment_name,
            'code' => $request->code,
            'asset_desc' =>$request->asset_desc,
            'category'=>$request->category,
            'unit' =>$request->unit,
            'model_number' =>$request->model_number,
            'serial_number' =>$request->serial_number,
            'asset_id' =>$request->asset_id,
            'remarks' =>$request->remarks,
        ]);
        dd($equipment, $request->category);
        // $equipment->update($request->validated());
        return ;
    }

    public function getEquipment($name)
    {

        abort_unless(auth()->check(), 403);

        return EquipmentOwned::query()
            ->join('equipment', 'equipment_owneds.equipment_id', 'equipment.id')
            ->join('offices', 'offices.id', 'equipment_owneds.office_id')
            ->join('assign_offices', 'assign_offices.id', 'offices.assign')
            ->join('equipment_details', 'equipment_details.equipment_owner', 'equipment_owneds.id')
            ->where('assign_offices.municipality', $name)
            ->get();

        return Equipment::where([['municipality_id', '=', $id], ['status', '=', 'serviceable']])->get();
    }

    public function equipmentList($name)
    {
        abort_unless(auth()->check(), 403);

        return Equipment::where('equipment_name', '=', $name)->get();
    }

    public function municipalityList($name, $quantity, LocationService $locationService)
    {

        $quantity = $quantity == null ? 1 : $quantity;
        return response()->json($locationService->getDistance($name, $quantity));
    }

    public function CrossMunicipalityList($name, $quantity, LocationService $locationService)
    {

        $quantity = $quantity == null ? 1 : $quantity;
        return response()->json($locationService->getDistance($name, $quantity, 'regional'));
    }

    public function equipmentAttr(Req $request)
    {

        $validated = $request->validate([
            'id' => 'required',
            'equipment_name' => 'required',
            'serial_number' => ['required', 'numeric'],
            'unit' => ['required', 'numeric'],
            'code' => 'required',
            'model_number' => ['required', 'numeric'],
            'asset_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        $status = $this->equipmentService->fulfillTransaction($request);

        if ($status == 200) {
            return response()->noContent($status);
        }

        if ($status == 400) {
            return response()->noContent($status);
        }
    }
}
