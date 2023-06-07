<?php

namespace App\Http\Controllers\Borrow;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\OfficeService;
use App\Models\Office;
use App\Models\EquipmentDetail;
use App\Models\EquipmentBorrow;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\BorrowHistory;
use App\Models\Approval;
use App\Http\Requests\BorrowUpdate;
use App\Http\Controllers\Controller;
use App\Events\TransactionDenied;
use App\Events\TransactionConfirmed;
use App\Events\NotifyProvince;

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


        DB::transaction(function () use($request ,$id) {
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
            if (!is_null($request->serviceable) && !is_null($request->poor) && !is_null($request->unserviceable)) {
                if ($request->serviceable + $request->poor + $request->unserviceable <= $details->quantity) {
                    BorrowHistory::create([
                        'borrowing_detail_id' => $detail->id,
                        'is_returned' => true,
                        'serviceable' => $request->serviceable,
                        'unserviceable' => $request->unserviceable,
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
    public function accepted(Request $request, $id)
    {

        $eb = EquipmentBorrow::find($id);
        // $eb->acquired =$eb->quantity;
        $detail = BorrowingDetails::find($eb->detail_id);
        $borrowing = Borrowing::find($detail->borrowing_id);

        $eb->authorize_quantity = $request->quantity;
        // $approval->acknowledge_at =  Carbon::now();

        $eb->status = 'accepted';
       
        $eb->save();

        
        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
        TransactionConfirmed::dispatch(Office::find($borrowing->borrower));
        // NotifyProvince::dispatch($officeService->ProvinceOffices());
        return redirect()->back();
    }
    public function deny(Request $request, $id)
    {
        // dd($request);
        $eb = EquipmentBorrow::find($id);
        // $eb->acquired =$eb->quantity;
        $detail = BorrowingDetails::find($eb->detail_id);
        $borrowing = Borrowing::find($detail->borrowing_id);
        // $borrowing->reason = $request->reason;
        $eb->authorize_quantity = $request->quantity;
        // $approval->acknowledge_at =  Carbon::now();
        $eb->reason = $request->reason;
        $eb->status = 'declined';
       
        $eb->save();

        
        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
        // $detail = BorrowingDetails::find($request->detail_id);
        // $borrow = Borrowing::find($detail->borrowing_id)->update([
        //     'owner_personel' => $request->personel,
        // ]);

        // $detail->status = 'denied';
        // $detail->save();
        // $unfinish = collect([
        //     'owner' => auth()->id(),
        //     'equipment' => $request->equipment,

        // ]);
        // $borrower = Office::where('name', $request->borrower)->first();
        TransactionDenied::dispatch(Office::find($eb->borrowee));
        return redirect()->back();
    }
}
