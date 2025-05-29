<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    public function rooms(){
        return $this->belongsToMany(Room::class, 'deal_room');
    }

    public function Reservation(){
        return $this->belongsToMany(Reservation::class, 'deal_reservation');
    }

    public function services(){
        return $this->belongsToMany(Service::class, 'deal_service');
    }
}
