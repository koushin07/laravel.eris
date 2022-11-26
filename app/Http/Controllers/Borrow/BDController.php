<?php

namespace App\Http\Controllers\Borrow;

use Illuminate\Http\Request;
use App\Services\OfficeService;
use App\Models\Office;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Http\Controllers\Controller;
use App\Events\TransactionDenied;
use App\Events\TransactionConfirmed;
use App\Events\NotifyProvince;
use App\Http\Requests\BorrowUpdate;
use App\Models\BorrowHistory;
use App\Models\Equipment;
use App\Models\EquipmentAttribute;
use Illuminate\Support\Facades\DB;

class BDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\BorrowingDetails  $borrowingDetails
     * @return \Illuminate\Http\Response
     */
    public function show(BorrowingDetails $borrowingDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BorrowingDetails  $borrowingDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(BorrowingDetails $borrowingDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BorrowingDetails  $borrowingDetails
     * @return \Illuminate\Http\Response
     */
    public function update(BorrowUpdate $request, $id)
    {


        DB::transaction(function () {
            $detail = BorrowingDetails::find($id);

            $attr = EquipmentAttribute::where([
                ['equipment_id', $detail->equipment_id],
                ['code', $request->code],
                ['asset_desc', $request->asset_desc],
                ['category', $request->category],
                ['unit', $request->unit],
                ['model_number', $request->model_number],
                ['serial_number', $request->serial_number],
                ['asset_id', $request->asset_id],
                ['remarks', $request->remarks],
            ])->first();
            $detail->equipment_attrs = $attrs->id;
            $detail->save();
            if (!is_null($request->serviceable) && !is_null($request->poor) && !is_null($request->unusable)) {
                if ($request->serviceable + $request->poor + $request->unusable <= $details->quantity) {
                    BorrowHistory::create([
                        'borrowing_detail_id' => $detail->id,
                        'is_returned' => true,
                        'serviceable' => $request->serviceable,
                        'unusable' => $request->unusable,
                        'poor' => $request->poor,
                    ]);
                }
            }
        }, 2);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BorrowingDetails  $borrowingDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(BorrowingDetails $borrowingDetails)
    {
        //
    }
    public function accepted(Request $request, OfficeService $officeService)
    {
        DB::transaction(function () use ($request) {
            // $borrowing = Borrowing::create([
            //     'borrower' => $request->borrower_id,
            //     'borrower_personel'=> $request->personel,
            //     'owner_personel' => 'owner_personel',
            //     'owner' => auth()->id(),
            // ]);
            // $equipment = Equipment::where('name', $request->equipment)->first();
            // $details = BorrowingDetails::create([
            //     'borrowing_id' => $borrowing->id,
            //     'equipment_id' => $equipment->id,
            //     'reason' => $request->incident,
            //     'quantity' =>  $request->quantity
            // ]);
            $detail = BorrowingDetails::find($request->detail_id);
            $borrow = Borrowing::find($detail->borrowing_id)->update([
                'owner_personel' => $request->personel,
            ]);

            $detail->status = 'accepted';
            $detail->save();
        });
        $borrower = Office::where('name', $request->borrower)->first();
        // $unfinish = UnfinishTransaction::create([
        //     'borrower' => $request->borrower_id,
        //     'owner' => auth()->id(),
        //     'quantity' => $request->quantity,
        //     'equipment' => $request->equipment
        // ]);
        $unfinish = collect([
            'owner' => auth()->id(),
            'equipment' => $request->equipment,
        ]);
        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
        TransactionConfirmed::dispatch($borrower, $unfinish);
        NotifyProvince::dispatch($officeService->ProvinceOffices());
        return redirect()->back();
    }
    public function deny(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
        $detail = BorrowingDetails::find($request->detail_id);
        $borrow = Borrowing::find($detail->borrowing_id)->update([
            'owner_personel' => $request->personel,
        ]);

        $detail->status = 'denied';
        $detail->save();
        $unfinish = collect([
            'owner' => auth()->id(),
            'equipment' => $request->equipment,

        ]);
        $borrower = Office::where('name', $request->borrower)->first();
        TransactionDenied::dispatch($borrower, $unfinish);
        return redirect()->back();
    }
}
