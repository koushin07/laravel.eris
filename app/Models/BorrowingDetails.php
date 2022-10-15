<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\EquipmentOwned;
use App\Models\Borrowing;

class BorrowingDetails extends Model
{
    use HasFactory;
    protected $fillable= ['equipment_id', 'borrowing_id', 'quantity'];

    public function equipment_owned()
    {
        return $this->belongsTo(EquipmentOwned::class);
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
    

}
