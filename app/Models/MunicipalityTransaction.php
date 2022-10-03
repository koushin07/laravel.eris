<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Municipality;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\SoftDeletes;

class MunicipalityTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =['municipality_id', 'equipment_id', 'quantity'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
