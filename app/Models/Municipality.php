<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Municipality extends Model
{
    use HasFactory, Notifiable;

   protected $fillabe=['municipality_name'];

   public function equipment()
   {
    return $this->hasMany(Equipment::class);
   }

   public function user()
   {
    return $this->hasMany(User::class);
   }

   public function province()
   {
    return $this->belongsTo(Province::class);
   }
}
