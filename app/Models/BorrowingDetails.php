<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\EquipmentOwned;
use App\Models\Borrowing;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BorrowingDetails extends Model
{
    use HasFactory, HasUuids;
    protected $fillable= ['borrowing_id', 'equipment_attrs', 
    'equipment_id', 'quantity', 'incident', 'incident_summary',
    'equipment_borrow_id'];

    public function equipment_owned()
    {
        return $this->belongsTo(EquipmentOwned::class);
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
    public function equipment(){
        return $this->belongsToMany(
            BorrowingDetails::class, 'equipment_borrows', 'equipment_id', 'detail_id'
        );
    }
   
    

}
