<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProvinceService;
use App\Services\MunicipalityTransactionService;
use App\Models\Province;
use App\Models\MunicipalityTransaction;
use App\Models\Municipality;
use App\Models\Equipment;
use App\Http\Requests\MunicipalityTransaction\CreateMTransactionRequest;
use App\Http\Requests\MTRequest;
use App\Http\Controllers\Controller;
use App\Events\NewMunicipalityTransaction;
use App\Events\MunicipalityTransactionEvent;

class MunicipalityTransactionController extends Controller
{

    protected $MTService;
    protected $Pservice;
    protected $UserService;
    public function __construct(
        UserService $userService,
        MunicipalityTransactionService $municipalityTransactionService,
        ProvinceService $provinceService
    ) {
        $this->UserService = $userService;
        $this->Pservice = $provinceService;
        $this->MTService = $municipalityTransactionService;
    }
    public function index()
    {
        return inertia('RecievedTransactionPage', [
            'borrows' => MunicipalityTransaction::select(
                [
                    'municipality_transactions.id',
                    'municipality_transactions.created_at',
                    'municipality_transactions.returned',
                    'municipality_transactions.quantity',
                    'municipalities.municipality_name',
                    'equipment.equipment_name',
                    'equipment.model_number',
                ]
            )
                ->join('equipment', 'municipality_transactions.equipment_id', '=', 'equipment.id')
                ->where('equipment.municipality_id', '=', auth()->user()->municipality_id)
                ->join('municipalities', 'equipment.municipality_id', '=', 'municipalities.id')
                ->where('confirm', '=', 1)->get(),
        ]);
    }


    public function recieved()
    {
        abort_unless(auth()->check(), 403);
        $borrows = MunicipalityTransaction::select(
            [
                'municipality_transactions.id',
                'municipality_transactions.created_at',
                'municipality_transactions.quantity',
                'municipalities.municipality_name',
                'equipment.equipment_name',
                'equipment.model_number',
            ]
        )
            ->join('equipment', 'municipality_transactions.equipment_id', '=', 'equipment.id')
            ->where('equipment.municipality_id', '=', auth()->user()->municipality_id)
            ->join('municipalities', 'equipment.municipality_id', '=', 'municipalities.id')
            ->where('confirm', '=', 1)
            ->skip(0)->limit(5)->get();

        return $borrows;
    }

    public function sent()
    {
        abort_unless(auth()->check(), 403);
        return MunicipalityTransaction::select([
            'municipality_transactions.*',
            'municipalities.municipality_name',
            'municipalities.id',
            'equipment.id',
            'equipment.equipment_name'
        ])->join('municipalities', 'municipalities.id', '=', 'municipality_transactions.municipality_id')
            ->where('municipalities.id', auth()->user()->municipality_id)
            ->join('equipment', 'equipment.id', '=', 'municipality_transactions.equipment_id')
            ->skip(0)->limit(5)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response    
     */
    public function create()
    {
        return inertia('localTransaction', [
            'municipalities' => Municipality::query()->when(request()->input('province'), function ($q, $id) {
                $q->where('province_id', $id);
            })->get(),
            'provinces' => Province::get(['id', 'province_name'])
            // 'equipments' => Equipment::where('status', 'Serviceable')->with(['municipality' =>
            // fn ($query) => $query->where('province_id',  $this->UserService->getUserProvince(
            //     auth()->user()->municipality_id
            // )->first()->id)])->get(['equipment_name', 'id'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MTRequest $request)
    {
        $request->validated();
        $this->MTService->insertData(
            $request['equipment_id'],
            $request['municipality_id'],
            $request['quantity']
        );
        // MunicipalityTransaction::create([
        //     'municipality_id' => auth()->user()->municipality_id,
        //     'equipment_id' => $request->equipment_id,
        //     'quantity' => $request->quantity,
        // ]);
       
        return redirect()->route('transactions.create')->with('message', 'doneeeeeeeee');
    }

    public function softDelete($id)
    {


        $borrows = MunicipalityTransaction::find($id);
        $borrows->delete();
        return back()->with('success', 'Request Sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('transaction.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
