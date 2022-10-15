<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Office;

class AssignOffice extends Model
{
    use HasFactory;

    protected $fillable =['municipality', 'province', 'is_rdrrmc'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
