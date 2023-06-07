<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Approvals as hasApprovals;

use App\Models\Role;
use App\Models\Municipality;
use App\Models\Assign_Office;
use App\Models\AssignOffice;

class Office extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, hasApprovals;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assign',
        'firstname',
        'lastname',
        'middlename',
        'suffix',
        'email',
        'address',
        'contact',
        'password',
        'must_reset_password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function assign_office()
    {
        return $this->belongsTo(AssignOffice::class, 'assign', 'id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // public function admin()
    // {
    //     return $this->with([
    //         'role' => function ($q) {
    //             $q->where('role_type', Role::ADMIN);
    //         }
    //     ]);
    // }
}
