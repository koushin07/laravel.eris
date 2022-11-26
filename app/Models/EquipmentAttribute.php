<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EquipmentAttribute extends Model
{
    use HasFactory, HasUuids;

    protected $fillable =[
        'equipment_id',
        'code',
        'asset_desc',
        'category',
        'unit',
        'model_number',
        'serial_number',
        'asset_id',
        'remarks',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function borrowing_detail()
    {
        return $this->belongsTo(BorrowingDetails::class);
    }
    
}
