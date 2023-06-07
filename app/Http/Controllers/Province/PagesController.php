<?php

namespace App\Http\Controllers\Province;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\Models\UnfinishTransaction;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\EquipmentOwned;
use App\Models\EquipmentBorrow;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\AssignOffice;
use App\Models\Approval;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function dashboard(Request $request)
    {
        $myProvince = AssignOffice::find(auth()->user()->assign);


        return inertia('Province/DashboardPage', [

            'locals' => Borrowing::select([
                'equipment.name',
                'borrowing_details.incident',
                'borrowing_details.incident_id',
                'borrowing_details.filename',
                'borrowing_details.id',
                DB::raw('aob.municipality as borrower'),
                DB::raw('ao.municipality as owner'),
                DB::raw("CONCAT(borrower.lastname , ' ' , borrower.firstname , ' ' , borrower.middlename, ' ' ,borrower.suffix) as borrower_personnel"),
                DB::raw("CONCAT(owner.lastname , ' ' , owner.firstname , ' ' , owner.middlename, ' ' ,owner.suffix) as owner_personnel"),
                'aob.province'

            ])


                ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')
                
                ->join('assign_offices as aob', DB::raw('aob.id'), '=', DB::raw('borrower.assign'))
                ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')

                ->join('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')

                ->join('offices as owner', DB::raw('owner.id'), '=', 'equipment_borrows.borrowee')
                ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('owner.assign'))
                ->leftJoin('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_borrows.equipment_attrs')
                ->join('equipment', 'equipment.id', '=', 'equipment_borrows.equipment_id') ->when($request->input('date'), function ($q, $date) {
                    $q->whereDate('borrowing_details.created_at', '=', Carbon::parse($date)->addDay()->format('Y-m-d'));
                })->when($request->input('id'), function ($q, $id) {
                    $q->where('borrowing_details.incident_id', '=', $id);
                })->when($request->input('name'), function ($q, $name) {
                    $q->where('borrowing_details.incident', 'like', '%'. $name .'%');
                })->where('aob.province', '=', $myProvince->province)->paginate(10),
            'regionals' => Borrowing::select([
                'equipment.name',
                'borrowing_details.incident',
                'borrowing_details.filename',
                DB::raw('aob.municipality as borrower'),
                DB::raw('ao.municipality as owner'),
                DB::raw("CONCAT(borrower.lastname , ' ' , borrower.firstname , ' ' , borrower.middlename, ' ' ,borrower.suffix) as borrower_personnel"),
                DB::raw("CONCAT(owner.lastname , ' ' , owner.firstname , ' ' , owner.middlename, ' ' ,owner.suffix) as personnel_owner"),
                'aob.province'

            ])

                ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')
                
                ->join('assign_offices as aob', DB::raw('aob.id'), '=', DB::raw('borrower.assign'))
                ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')

                ->join('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')

                ->join('offices as owner', DB::raw('owner.id'), '=', 'equipment_borrows.borrowee')
                ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('owner.assign'))
                ->leftJoin('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_borrows.equipment_attrs')
                ->join('equipment', 'equipment.id', '=', 'equipment_borrows.equipment_id')
                ->where('aob.province',  $myProvince->province)
                ->paginate(10),
            // 'reports' => BorrowingDetails::select([
            //     'borrowing_details.incident',
            //     'borrowing_details.incident_summary',
            //     'borrowing_details.filename',
            //     'borrowing_details.created_at',
            //     'assign_offices.municipality',
            //     DB::raw("CONCAT(borrower.lastname , ' ' , borrower.firstname , ' ' , borrower.middlename, ' ' ,borrower.suffix) as borrower"),
            // ])->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')
            //     ->join('offices as owner', DB::raw('owner.id'), '=', 'borrowings.owner')
            //     ->join('offices as borrower', DB::raw('borrower.id'), '=', 'approvals.borrowee')->join('assign_offices', 'assign_offices.id', '=', DB::raw('borrower.assign'))->where('assign_offices.province', '=', $myProvince->province)->paginate(10)
        ]);
    }
    public function consolidated(Request $request)
    {
        $myProvince = AssignOffice::find(auth()->user()->assign);

        return inertia('Province/ConsolidatedPage', [

            'municipalities' => AssignOffice::where('province', $myProvince->province)->whereNotNull('municipality')->get(),
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
                ->where('assign_offices.province', $myProvince->province)->orderBy('available', 'ASC')
                ->groupBy('name', 'municipality')
                ->when($request->input('search'), function ($q, $search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->when($request->input('municipality'), function ($q, $municipality) {
                    $q->where('assign_offices.municipality', $municipality);
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
                       WHERE o.id = :myid",
                [
                    'myid' => auth()->id(),
                ]
            )[0],
            'notification' => auth()->user()->unreadNotifications()->count(),
            'equipment_dropdown' => Equipment::all(),
        ]);
    }

    public function consolidatedShow(Request $request, $id)
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
                ->leftJoin('borrow_histories', 'borrow_histories.borrowing_detail_id', '=', 'borrowing_details.id')
               ->where('equipment_borrows.equipment_id', $id)
                ->where('assign_offices.municipality', '=', $request->municipality)
                ->groupBy(['assign_offices.municipality'])->orderBy('frequent', 'DESC');
    
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
                'equipments' =>  $equipment,
                'owned' => $owned->paginate(10)->onEachSide(1),
                'borrow' => $borrow->paginate(10)->onEachSide(1),
                'tracks' => $tracks,
    
            ]);
            
        
    }
    public function transaction()
    {
        $myProvince = AssignOffice::find(auth()->user()->assign);
        return inertia('Province/TransactionPage', [
            'locals' => DB::select("SELECT e.name, aob.municipality as borrower,
             ao.municipality as owner, 
             attrs.*
             FROM borrowing_details bd
            JOIN borrowings b ON b.id = bd.borrowing_id
            JOIN approvals a ON a.id = b.approval_id
            JOIN offices borrower ON borrower.id = a.borrowee
            JOIN assign_offices aob ON aob.id = borrower.id
            JOIN equipment_borrows eb ON eb.detail_id = bd.id
            JOIN equipment e ON e.id = eb.equipment_id
            JOIN equipment_attributes attrs ON attrs.id = eb.equipment_attrs
            JOIN offices owner ON owner.id = b.owner
            JOIN assign_offices ao ON ao.id = owner.assign
            WHERE ao.province = :province", [
                'province' => $myProvince->province
            ]),
            'regionals' => DB::select("SELECT e.*,  aob.municipality as borrower,
            ao.municipality as owner FROM borrowing_details bd
            
            JOIN borrowings b ON b.id = bd.borrowing_id
            JOIN approvals a ON a.id = b.approval_id
            JOIN offices borrower ON borrower.id = a.borrowee
            JOIN assign_offices aob ON aob.id = borrower.id
            JOIN equipment_borrows eb ON eb.detail_id = bd.id
            JOIN equipment e ON e.id = eb.equipment_id
            JOIN equipment_attributes attrs ON attrs.id = eb.equipment_attrs
            JOIN offices owner ON owner.id = b.owner
            JOIN assign_offices ao ON ao.id = owner.assign
            WHERE NOT ao.province = :province", [
                'province' => $myProvince->province
            ])
        ]);
    }
    public function request()
    {
        return inertia('Province/RequestPage', [
            'municipalities' => Office::select(['offices.id', 'assign_offices.municipality'])
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->whereNotNull('assign_offices.municipality')
                ->get()
        ]);
    }

    public function archive(Request $request)
    {
        $myProvince = AssignOffice::find(auth()->user()->assign);
        return inertia('Province/ArchivePage', [
            'incidents' => BorrowingDetails::select([
                'borrowing_details.id',
                'borrowing_details.incident',
                'assign_offices.municipality',
                'borrowing_details.INC_submitted_at as submitted_at',
                'borrowing_details.filename',
                'borrowing_details.file_path',
                'borrowing_details.created_at'
            ])
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')
                ->join('offices', 'offices.id', '=', 'approvals.borrowee')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->where('assign_offices.province', '=', $myProvince->province)->whereNotNull(['assign_offices.municipality', 'borrowing_details.filename'])
                ->when($request->input('date'), function ($q, $date) {
                    $q->whereDate('borrowing_details.INC_submitted_at', '=', Carbon::parse($date)->format('Y-m-d'));
                })
                // ->when($request->input('municipality'), function ($q, $municipality) {
                //     $q->where('assign_offices.id', '=', $municipality);
                // })
                ->paginate(8),
            'provinces' => AssignOffice::with('office')->whereNull('municipality')->whereNotNull('province')->get(),
        ]);
    }
}
