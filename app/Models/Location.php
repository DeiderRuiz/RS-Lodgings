<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'ciudad',
        'direccion',
        'url',
        'cellphone_hotel',
        'descripcion',
        'portada',
    ];
    
    /* public function getRouteKeyName()
    {
        return 'ciudad';
    } */
    public function Galery(){
        return $this->hasMany(Galery::class);
    }
    public function ratings(){
        return $this->hasMany(Rating::class, 'locations_id');
    }
}
