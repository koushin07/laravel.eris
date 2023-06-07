<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Office;
use App\Models\Borrowing;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Approval extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = ['borrowee', 'status', 'acknowledge_at', 'reason'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function borrowing()
    {
        return $this->hasMany(Borrowing::class) ;
    }
    
}
