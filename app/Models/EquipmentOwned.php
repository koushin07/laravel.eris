<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Office;
use App\Models\Equipment;

class EquipmentOwned extends Model
{
    use HasFactory;

    protected $fillable=['equipment_id', 'office_id', 'quantity'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function condition()
    {
        return $this->hasMany(Condition::class);
    }
}

