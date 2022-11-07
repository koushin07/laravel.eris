<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BorrowingDetails;

class BorrowHistory extends Model
{
    use HasFactory;

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
