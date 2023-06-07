<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDetail extends Model
{
    use HasFactory, HasUuids;

    protected $fillable=['equipment_owner', 'serviceable', 'unserviceable', 'poor'];

    public function equipment_owned()
    {
        $this->belongsTo(EquipmentOwned::class, 'equipment_owner', 'id');
    }

    public function equipment_borrow(){
        return $this->hasMany(EquipmentBorrow::class, 'detail_id', 'id');
    }
}
