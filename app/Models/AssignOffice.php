<?php

namespace App\Models;

use Znck\Eloquent\Traits\BelongsToThrough;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Office;

class AssignOffice extends Model
{
    use HasFactory, HasUuids, BelongsToThrough;

    protected $fillable =['municipality', 'province', 'is_rdrrmc', 'latitude', 'longitude'];

    protected $guarded= ['id'];
    public function office()
    {
        return $this->hasMany(Office::class, 'assign');
    }

    public function role()
    {
        return $this->belongsToThrough(Role::class, Office::class, [Office::class => 'assign'] );
    }
}
