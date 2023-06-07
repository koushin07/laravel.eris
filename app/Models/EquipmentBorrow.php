<?php

namespace App\Models;

use \Znck\Eloquent\Traits\BelongsToThrough;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\EquipmentDetail;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use Illuminate\Database\Eloquent\MassPrunable;

class EquipmentBorrow extends Model
{
    use HasFactory, HasUuids, BelongsToThrough, MassPrunable;

    protected $fillable = [
        'equipment_id',
        'equipment_attrs',
        'detail_id',
        'status',
        'quantity',
        'borrowee'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public function equipment_attribute()
    {
        return $this->belongsToMany(EquipmentAttribute::class);
    }
    public function equipment_detail()
    {
        return $this->belongsToMany(EquipmentDetail::class, 'detail_id', 'id');
    }
    public function borrowing()
    {
        return $this->BelongsToThrough(Borrowing::class, BorrowingDetails::class,);
    }

    public function prunable()
    {
        return static::where([
            ['status', '=', 'accepted'],
            ['acquired', '=', 0],
            ['updated_at', '<=', now()->subDays(3)]
        ]);
    }
}
