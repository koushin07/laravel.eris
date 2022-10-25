<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowDetail extends Model
{
    use HasFactory;
    protected $fillable =['borrowing_id', 'serviceable', 'poor', 'unusable'];
}
