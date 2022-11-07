<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Office;
use App\Models\EquipmentDetail;
use App\Models\Equipment;

class EquipmentOwned extends Model
{
    use HasFactory;

    protected $fillable=['equipment_id', 'office_id'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function equipment_detail()
    {
        return $this->hasMany(EquipmentDetail::class, 'equipment_owner');
    }
}

