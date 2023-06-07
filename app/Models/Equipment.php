<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\EquipmentOwned;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Equipment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'recieved_at'
    ];

    

    
    public function equipment_owned()
    {
        return $this->hasMany(EquipmentOwned::class);
    }
    
    public function borrowing_detail()
    {
        return $this->belongsToMany(
            BorrowingDetails::class, 'equipment_borrows', 'equipment_id', 'detail_id', 'recieved_at'
        );
    }
    
    public function equipment_attribute()
    {
        return $this->belongsToMany(EquipmentAttribute::class, 'equipment_owneds', 'equipment_id', 'equipment_attrs',);
    }

    public function equipment_detail()
    {
        return $this->hasManyThrough(EquipmentDetail::class, EquipmentOwned::class, 'equipment_id', 'equipment_owner');
    }
   
    public function equipment_borrow()
    {
        return $this->hasMany(EquipmentBorrow::class);
    }



  
}
