<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function Reservation(){
        return $this->belongsToMany(Reservation::class);
    }

    public function rooms(){
        return $this->belongsToMany(Room::class);
    }

    public function deals(){
        return $this->belongsToMany(Deal::class, 'deal_service');
    }
}
