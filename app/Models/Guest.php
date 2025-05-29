<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'cedula',
        'name',
        'last_name',
        'cellphone',
        'email',
    ];

    public function PQRS(){
        return $this->hasMany(Pqrs::class);
    }

    public function Payment(){
        return $this->hasMany(Payment::class);
    }

    public function Reservation(){
        return $this->hasMany(Reservation::class);
    }
}
