<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'fecha_inicio',
        'fecha_fin',
        'huespedes',
        'noches',
        'monto_habitacion',
        'monto_extra_huesped',
        'monto_noche_extra',
        'monto_servicios',
        'estado',
        'guest_id',
        'user_id',
        'room_id',
    ];

    public function getRouteKeyName(){
        return 'uuid';
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function guest(){
        return $this->belongsTo(Guest::class);
    }

    public function Payment(){
        return $this->hasOne(Payment::class);
    }

    public function rooms(){
        return $this->belongsToMany(Room::class, 'reservation_room');
    }

    public function service(){
        return $this->belongsToMany(Service::class, 'reservation_service');
    }

    public function Deal(){
        return $this->belongsToMany(Deal::class, 'deal_reservation');
    }
}
