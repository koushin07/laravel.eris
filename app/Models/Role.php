<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable=['role_type'];
    const MUNICIPALITY = 1;
    const PROVINCE = 2;
    public function office()
    {
        return $this->hasMany(Office::class);
    }
}
