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
use App\Models\AssignOffice;
use App\Models\Borrowing;
use PhpParser\Node\Expr\Assign;

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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response    
     */
    public function create()
    {
        return inertia('localTransaction', [
            'municipalities' => AssignOffice::query()->when(request()->input('province'), function ($q, $id) {
                $q->where('province_id', $id);
            })->get(),
            'provinces' => AssignOffice::get(['id', 'province_name'])
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
        // dd( $request);
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
