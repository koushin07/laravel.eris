<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Office;
use App\Models\EquipmentDetail;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EquipmentOwned extends Model
{
    use HasFactory, HasUuids;

    protected $fillable=['equipment_id', 'office_id', 'equipment_attrs'];

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
        return $this->hasOne(EquipmentDetail::class, 'equipment_owner');
    }

    public function equipment_attribute()
    {
        return $this->belongsTo(EquipmentAttribute::class,'equipment_attrs');
    }
}

