<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Returned;
use App\Models\Office;

class Borrowing extends Model
{
    use HasFactory;


    protected $fillable = ['borrower', 'owner', 'confirmation'];

    public function returned()
    {
        return $this->belongsToMany(Borrowing::class);
    }


}
