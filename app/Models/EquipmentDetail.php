<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDetail extends Model
{
    use HasFactory, HasUuids;

    protected $fillable=['equipment_owner', 'serviceable', 'unusable', 'poor'];

    public function equipment_owned()
    {
        $this->belongsTo(EquipmentOwned::class, 'equipment_owner', 'id');
    }
}
