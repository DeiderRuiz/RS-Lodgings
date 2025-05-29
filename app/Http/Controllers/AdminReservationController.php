<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminReservationController extends Controller
{
    public function index(){
        $reservas = Reservation::with(['user', 'guest', 'rooms'])->get();
        return Inertia::render('Admin/Reservations/Index', ['reservas' => $reservas]);
    }

    public function show(Reservation $reserva){
        return Inertia::render('Admin/Reservations/Show', ['reserva' => $reserva->load('user', 'guest', 'rooms', 'service')]);
    }
}
