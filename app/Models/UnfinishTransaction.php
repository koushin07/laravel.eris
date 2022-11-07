<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnfinishTransaction extends Model
{
    use HasFactory;

    protected $fillable=['borrower', 'owner', 'equipment', 'quantity'];

    public function borrower()
    {
        return $this->belongsTo(Office::class, 'borrower', 'id');
    }
    public function owner()
    {
        return $this->hasMany(Office::class);
    }
}
