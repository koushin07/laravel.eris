<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Returned;
use App\Models\Office;
use App\Models\BorrowingDetails;
use App\Models\BorrowHistory;

class Borrowing extends Model
{
    use HasFactory, HasUuids;


    protected $fillable = ['borrower', 'owner', 'borrower_personel', 'owner_personel'];

   
    public function history()
    {
        return $this->hasManyThrough(BorrowHistory::class, BorrowingDetails::class, 'borrowing_id','borrowing_detail_id', 'id', 'id');
    }

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d',
    // ];
}
