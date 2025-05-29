<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RoomServiceController extends Controller
{
    public function show(Room $room){
        $services = Service::where('para_habitacion', 1)->get();
        $exclusive_services = $room->services->pluck('id')->ToArray();
        return Inertia::render('Admin/RoomService/Show', [
            'room'=>$room, 
            'services'=>$services, 
            'exclusive_services'=>$exclusive_services
        ]);
    }

    public function attach(Room $room, $service){
        $room->services()->attach($service);
        return redirect()->back()->with('message', "Has agregado un servicio exclusivo a la habitación N°{$room->numero}");
    }

    public function detach(Room $room, $service){
        $room->services()->detach($service);
        return redirect()->back()->with('message', "Has removido un servicio exclusivo a la habitación N°{$room->numero}");
    }
}
