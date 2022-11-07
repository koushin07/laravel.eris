<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable=[
        'reciever',
        'sender',
        'file_path',
        'filename'
    ];

    public function reciever()
    {
        return $this->belongsTo(Office::class, 'reciever', 'id');
    }
    public function sender()
    {
        return $this->belongsTo(Office::class, 'sender', 'id');
    }
}
