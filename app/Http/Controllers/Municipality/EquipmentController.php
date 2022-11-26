<?php

namespace App\Http\Controllers\Municipality;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as Req;
use Illuminate\Auth\Events\Validated;
use App\Services\LocationService;
use App\Services\EquipmentService;
use App\Models\User;
use App\Models\Municipality;
use App\Models\EquipmentOwned;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\AssignOffice;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Controllers\Controller;
use App\Events\NewEquipmentAdded;
use App\Models\EquipmentAttribute;
use App\Models\EquipmentDetail;

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
                    'equipment.name',
                    'equipment_attributes.*',
                    'offices.name as owner',
                    'equipment_details.id as detail_id',
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
                    Request::input('search'),
                    function ($q, $search) {
                        $q->where('equipment.name', 'like', '%' . $search . '%');
                    }
                )->where('equipment_owneds.office_id', auth()->id())
                ->paginate(10)->onEachSide(1),

            'filters' => Request::only(['search', 'status', 'owner']),
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
                ->count()
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
        return redirect()->route('municipality.inventory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return inertia('municipality/InventoryPage', [
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
                    Request::input('search'),
                    function ($q, $search) {
                        $q->where('equipment.name', 'like', '%' . $search . '%');
                    }
                )->where('equipment_owneds.office_id', auth()->id())
                ->paginate(5)->onEachSide(1)->withQueryString(),

            'filters' => Request::only(['search', 'status', 'owner'])
        ]);
    }

    public function update(UpdateEquipmentRequest $request, $id)
    {
        $request->validated();
       
       DB::transaction(function() use($request, $id) {
        $attrs = EquipmentAttribute::find($id);
        $equipment = Equipment::find($attrs->equipment_id);
        // dd($attrs, $equipment);
        $attrs->update([
             'code' => $request->code,
            'asset_desc' =>$request->asset_desc,
            'category'=>$request->category,
            'unit' =>$request->unit,
            'model_number' =>$request->model_number,
            'serial_number' =>$request->serial_number,
            'asset_id' =>$request->asset_id,
            'remarks' =>$request->remarks,
        ]);
        $detail = EquipmentDetail::find($request->detail_id);
        $detail->update([
            'serviceable' => $request->serviceable,
            'poor' => $request->poor,
            'unusable' => $request->unusable
        ]);
        $equipment->update([
            
            'name' => $request->name,
        ]);

       });
        
        // $equipment->update($request->validated());
        return redirect()->back();
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

    public function municipalityList(Req $request, LocationService $locationService)
    {

        return response()->json($locationService->getDistance($request->equipment, $request->provinces));
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
