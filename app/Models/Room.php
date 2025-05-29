<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'disponibilidad',
    ];

    public function reservations(){
        return $this->belongsToMany(Reservation::class, 'reservation_room');
    }

    public function services(){
        return $this->belongsToMany(Service::class);
    }

    public function deals(){
        return $this->belongsToMany(Deal::class, 'deal_room');
    }
}
