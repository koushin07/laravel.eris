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
        'is_returned',
        'serviceable',
        'unusable',
        'poor',
    ];

    public function borrowing_detail()
    {
        return $this->belongsTo(BorrowingDetails::class);
    }
}
