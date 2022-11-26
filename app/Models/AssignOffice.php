<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Office;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AssignOffice extends Model
{
    use HasFactory, HasUuids;

    protected $fillable =['municipality', 'province', 'is_rdrrmc', 'latitude', 'longitude'];

    protected $guarded= ['id'];
    public function office()
    {
        return $this->hasMany(Office::class, 'assign');
    }
}
