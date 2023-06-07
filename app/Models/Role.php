<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['role_type'];
    public const MUNICIPALITY = 'RDRRMC_MUNICIPALITY';
    public const PROVINCE = 'RDRRMC_PROVINCE';
    public const ADMIN = 'RDRRMC';
    public function office()
    {
        return $this->hasMany(Office::class);
    }

   
}
