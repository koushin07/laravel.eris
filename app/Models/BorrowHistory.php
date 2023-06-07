<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BorrowingDetails;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BorrowHistory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'borrowing_detail_id',
        'return_at',
        'serviceable',
        'unserviceable',
        'poor',
    ];

    public function borrowing_detail()
    {
        return $this->belongsTo(BorrowingDetails::class);
    }
}
