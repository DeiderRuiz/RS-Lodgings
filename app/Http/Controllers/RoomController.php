<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Service;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(){
        $rooms=Room::select(
            'id', 'numero', 'tipo', 'detalles', 'vista', 'precio', 
            'precio_huesped', 'precio_noche_extra', 'disponibilidad'
        )->get();
        
        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        return match ($role) {
            3 => Inertia::render('Customers/Rooms/Index', ['rooms' => $rooms]),
            null => Inertia::render('Rooms/Index', ['rooms' => $rooms]),
            default => redirect()->route('index'),
        };

    }

    public function show(Room $room){
        //Trae a los servicios todos los exclusivos de una habitación
        $exclusive_services = DB::table('room_service')
        ->join('services', 'room_service.service_id', '=', 'services.id')->where('room_id', $room->id)
        ->where('para_habitacion', true)->select('services.nombre', 'services.tipo', 'services.precio')->get();
        //Se trae al resto de servicios (Los que son para cualquier habitación)
        $services = Service::where('para_habitacion', false)->get();
        //Retorna el cuarto junto con todos los servicios que con los que cuenta
        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        return match ($role) {
            3 => Inertia::render('Customers/Rooms/Show', ['room'=>$room, 'exclusive_services'=>$exclusive_services, 'services'=>$services]),
            null => Inertia::render('Rooms/Show', ['room'=>$room, 'exclusive_services'=>$exclusive_services, 'services'=>$services]),
            default => redirect()->route('index'),
        };
    }
}
