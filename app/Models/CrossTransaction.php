<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Municipality;
use App\Models\Equipment;

class CrossTransaction extends Model
{
    use HasFactory, SoftDeletes ,Notifiable;

    protected $fillable = [
        'municipality_id',
        'equipment_id',
        'quantity',
    ];

    public function equipment()
    {
        return $this->BelongsTo(Equipment::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
