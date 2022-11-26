<?php

namespace App\Http\Controllers\Borrow;

use App\Events\NotifyProvince;
use App\Events\TransactionConfirmed;
use App\Events\TransactionDenied;
use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\UnfinishTransaction;
use App\Services\OfficeService;
use Illuminate\Http\Request;

class UnfinishTransactionController extends Controller
{
   
    public function accepted(Request $request, OfficeService $officeService)
    {

        $unfinish = UnfinishTransaction::create([
            'borrower' => $request->borrower_id,
            'owner' => auth()->id(),
            'quantity' => $request->quantity,
            'equipment' => $request->equipment
        ]);
        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
        TransactionConfirmed::dispatch(Office::find($request->borrower_id), $unfinish);
        NotifyProvince::dispatch($officeService->authMunicipalityProvince(), $unfinish->equipment);
        return response()->noContent();
    }
    public function deny(Request $request)
    {

        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();

        TransactionDenied::dispatch(Office::find($request->borrower_id), $unfinish);
        return response()->noContent();
    }
    public function serviceTest(OfficeService $officeService)
    {
        return $officeService->authMunicipalityProvince();
    }
}
