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

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Equipments', [
            'equipments' => Equipment::query()
                ->when(
                    Request::input('search'),
                    function ($q, $search) {
                        $q->where('equipment_name', 'like', '%' . $search . '%');
                    }
                )->when(
                    Request::input('status'),
                    function ($q, $status) {
                        $q->where('status', 'like', '%' . $status . '%');
                    }
                )->when(
                    Request::input('owner'), 
                    function ($q, $owner) {
                    $q->Where('municipality_id', auth()->user()->municipality_id);
                })
                ->paginate(10)->onEachSide(1)->withQueryString(),

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

        // $this->authorize('municipality');
        if(!$equipmentService->checkIfExist($request->validated())){
            return redirect('/dashboard');
        };
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
            'name' => Municipality::select('municipality_name')->find($id),
            'equipments' => Equipment::where('municipality_id', $id)->when(Request::input('search'), function ($q, $search) {
                $q->where('equipment_name', 'like', '%' . $search . '%');
            })->when(Request::input('status'), function ($q, $status) {
                $q->where('status', 'like', '%' . $status . '%');
            })
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

    public function getEquipment($id)
    {

        abort_unless(auth()->check(), 403);

        return Equipment::where([['municipality_id', '=', $id], ['status', '=', 'serviceable']])->get();
    }

    public function equipmentList($name)
    {
        abort_unless(auth()->check(), 403);

        return Equipment::where([['equipment_name', '=', $name], ['status', '=', 'serviceable']])->get();
    }
}
