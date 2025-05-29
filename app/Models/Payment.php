<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto_total',
        'fecha_pago',
        'estado',
        'guest_id',
        'reservation_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function guest(){
        return $this->belongsTo(Guest::class);
    }

    public function Reservation(){
        return $this->belongsTo(Reservation::class);
    }
}
