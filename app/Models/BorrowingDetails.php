<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\EquipmentOwned;
use App\Models\EquipmentBorrow;
use App\Models\Equipment;
use App\Models\Borrowing;

class BorrowingDetails extends Model
{
    use HasFactory, HasUuids, MassPrunable;
    protected $fillable = [
        'borrowing_id', 'equipment_attrs',
        'equipment_id', 'quantity', 'incident', 'incident_summary',
        'equipment_borrow_id', 'created_at',
        'incident_id', 'INC_submitted_at'
    ];

    public function equipment_owned()
    {
        return $this->belongsTo(EquipmentOwned::class);
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
    public function equipment()
    {
        return $this->belongsToMany(
            Equipment::class,
            'equipment_borrows',
            'detail_id',
            'equipment_id'
        );
    }

    public function equipment_borrow()
    {
        return $this->hasMany(EquipmentBorrow::class, 'detail_id', 'id');
    }


    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::leftJoin('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')->whereNull('detail_id');
    }


}
