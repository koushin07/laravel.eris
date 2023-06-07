<?php

namespace App\Models;

use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Returned;
use App\Models\Office;
use App\Models\BorrowingDetails;
use App\Models\BorrowHistory;



class Borrowing extends Model
{
    use HasFactory, HasUuids, MassPrunable;


    protected $fillable = [ 'borrower', 'acknowlegde_at', 'reason' ];

   
    public function history()
    {
        return $this->hasManyThrough(BorrowHistory::class, BorrowingDetails::class, 'borrowing_id','borrowing_detail_id', 'id', 'id');
    }
    public function borrowing_detail()
    {
        return $this->hasMany(BorrowingDetails::class);
    }

    public function prunable()
    {
        return static::leftJoin('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')->whereNull('borrowing_id');
    }

  

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d',
    // ];
}
