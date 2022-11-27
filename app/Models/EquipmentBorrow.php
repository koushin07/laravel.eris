<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\EquipmentDetail;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;

class EquipmentBorrow extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'equipment_id',
        'equipment_attrs',
        'detail_id',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public function equipment_attribute()
    {
        return $this->belongsTo(EquipmentAttribute::class);
    }
    public function equipment_detail()
    {
        return $this->belongsTo(EquipmentDetail::class, 'detail_id', 'id');
    }
}
