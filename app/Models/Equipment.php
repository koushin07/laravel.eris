<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\EquipmentOwned;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_name',
        'code',
        'asset_desc',
        'category',
        'unit',
        'model_number',
        'serial_number',
        'asset_id',
        'remarks',
        'quantity',
    ];


    public function equipment_owned()
    {
        return $this->hasMany(EquipmentOwned::class);
    }
}
