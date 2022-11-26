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

    ];


    public function equipment_owned()
    {
        return $this->hasMany(EquipmentOwned::class);
    }
    
    public function borrowing_detail()
    {
        return $this->hasMany(BorrowingDetails::class);
    }
    
    public function equipment_attribute()
    {
        return $this->hasMany(EquipmentAttribute::class);
    }
}
