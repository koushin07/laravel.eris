<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\EquipmentOwned;
use App\Models\EquipmentDetail;
use App\Models\EquipmentBorrow;
use App\Models\Equipment;
use App\Http\Controllers\Controller;
use App\Models\AssignOffice;

class AdminInventoryController extends Controller
{
   
    public function index(Request $request)
    {
        return inertia('Admin/InventoryPage', [

            'equipments' => Equipment::select([
                'equipment.*',
                DB::raw('count(equipment_attributes.id) as attrs'),
                DB::raw('sum(equipment_details.serviceable) as available'),
                DB::raw('sum(equipment_details.unserviceable) as damages'),
                'assign_offices.municipality'
            ])
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_owneds.equipment_attrs')
                ->orderBy('available', 'ASC')
                ->groupBy('name', 'municipality')
                ->when($request->input('search'), function ($q, $search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->when($request->input('municipality'), function ($q, $municipality) {
                    $q->where('municipality', '=', $municipality);
                })
                ->paginate(10)->onEachSide(1),
            'filters' => $request->only(['search', 'status', 'owner']),
            'status' => DB::select(
                "SELECT
                SUM(serviceable + unserviceable + poor) AS total,
                        SUM(serviceable) AS serviceable,
                        SUM(unserviceable) AS unserviceable,
                        SUM(poor) AS poor
                      FROM equipment_details ed
                      JOIN equipment_owneds eo ON eo.id = ed.equipment_owner
                      JOIN offices o ON o.id = eo.office_id
                      ",
              
            )[0],
            'notification' => auth()->user()->unreadNotifications()->count(),

            'criticals' =>  EquipmentDetail::select([
                'equipment.name',
                DB::raw('sum(equipment_details.serviceable)'),
                'equipment_owneds.equipment_id as id'
            ])
    
                ->join('equipment_owneds', 'equipment_owneds.id', '=', 'equipment_details.equipment_owner')
                ->join('equipment', 'equipment.id', '=', 'equipment_owneds.equipment_id')
                ->orderBy('serviceable', 'asc')
                ->get()->groupBy('name', 'municipality')->map(function ($total) {
                $sum =  $total->sum('serviceable');
                if($sum > 3){
                        return $total->sum('serviceable');
                }
                  
                })->sort()->take(3),
            'municipalities' => AssignOffice::select(['assign_offices.municipality'])
            ->join('offices', 'offices.assign', '=', 'assign_offices.id')
            ->whereNotNull('municipality')->get()

        ]);
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

   
    public function show(Request $request, $id)
    {

        // dd($request->municipality);
        $equipment = Equipment::find($id);
        $owned = EquipmentOwned::select([
            'equipment_owneds.id',
            'equipment_attributes.id as attrs_id',
            'equipment_details.id as detail_id',
            'equipment_attributes.code',
            'equipment_attributes.asset_desc',
            'equipment_attributes.category',
            'equipment_attributes.unit',
            'equipment_attributes.model_number',
            'equipment_attributes.serial_number',
            'equipment_attributes.asset_id',
            'equipment_attributes.remarks',
            'equipment_details.serviceable',
            'equipment_details.poor',
            'equipment_details.unserviceable'
        ])
            ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
            ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_owneds.equipment_attrs')
            ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->where('equipment_owneds.equipment_id', '=', $id)
            ->where('assign_offices.municipality', '=', $request->municipality)
            ->when(
                $request->input('status'),
                function ($q, $status) {
                    if ($status == 'Serviceable') {
                        $q->whereColumn('equipment_details.poor', '<=', 'equipment_details.serviceable')->whereColumn('equipment_details.unserviceable', '<=', 'equipment_details.serviceable');
                    }
                    if ($status == 'Poor') {
                        $q->whereColumn('equipment_details.poor', '>=', 'equipment_details.serviceable')->whereColumn('equipment_details.unserviceable', '<=', 'equipment_details.poor');
                    }
                    if ($status == 'Unusable') {
                        $q->whereColumn('equipment_details.poor', '<=', 'equipment_details.unserviceable')->whereColumn('equipment_details.unserviceable', '>=', 'equipment_details.serviceable');
                    }
                }
            );

        /* NOTE:
                ? get equipment borrow detials
                ! municipality most borrow
                ! number of returns and not return per municipality
                ! most reason(incident) equipment borrow
                !! all with DATES
             */
        $borrow = EquipmentBorrow::select([
            'equipment_borrows.id as eb_id',
            'equipment_borrows.equipment_id as eqip_id',
            'ao.municipality',
            DB::raw(" CONCAT(offices.lastname , ' ' , offices.firstname , ' ' , offices.middlename, ' ' ,offices.suffix) as borrower"),
            DB::raw("borrow_histories.return_at as date_returned"),
            'borrowing_details.created_at as date_borrowed',
            DB::raw('sum(borrow_histories.serviceable) as serviceable'),
            DB::raw('sum(borrow_histories.unserviceable) as unserviceable'),
            DB::raw('sum(borrow_histories.poor) as poor'),
            DB::raw('sum(borrow_histories.serviceable) + sum(borrow_histories.unserviceable) + sum(borrow_histories.poor) as total_return '),
            DB::raw('sum(equipment_borrows.acquired) as total_borrow'),
            DB::raw('count(assign_offices.municipality) as frequent')
        ])
            ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')

            ->join('offices', 'offices.id', '=', 'equipment_borrows.borrowee')
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')
            ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('borrower.assign'))
            ->leftJoin('borrow_histories', 'borrow_histories.borrowing_detail_id', '=', 'borrowing_details.id') ->where('assign_offices.municipality', '=', $request->municipality)
           ->where('equipment_borrows.equipment_id', $id)->groupBy(['assign_offices.municipality'])->orderBy('frequent', 'DESC');

        $tracks = new Collection();
        if (!empty($borrow->first())) {


            $tracks->put('mean',  collect([
                ['total_of_borrow' => $borrow->get()->sum('total_borrow')],
                ['total_of_return' => $borrow->get()->sum('total_return')],
                ['total_serviceable' => $owned->get()->sum('serviceable')],
                ['total_unserviceable' => $owned->get()->sum('unserviceable')],
                ['total_poor' => $owned->get()->sum('poor')],
            ]));
            $tracks->put('mode', collect([
                ['frequent_municipality' => $borrow->first()->only('frequent', 'municipality')]
            ]));
            $tracks->put('min', collect([
                ['less_return' => $borrow->get()->sortBy('total_return')->first()]
            ]));
        }


        return inertia('Admin/EquipmentBackTrack', [
            'myMuni' => $request->municipality,
            'equipments' =>  $equipment,
            'owned' => $owned->paginate(10)->onEachSide(1),
            'borrow' => $borrow->paginate(10)->onEachSide(1),
            'tracks' => $tracks,

        ]);
        
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
