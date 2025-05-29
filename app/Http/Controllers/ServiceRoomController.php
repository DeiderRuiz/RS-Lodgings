<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceRoomController extends Controller
{
    public function show(Service $service){
        $rooms = Room::get();
        $attached_rooms = $service->rooms->pluck('id')->ToArray();
        return Inertia::render('Admin/ServiceRoom/Show', [
            'service'=>$service, 
            'rooms'=>$rooms, 
            'attached_rooms'=>$attached_rooms
        ]);
    }

    public function attach(Service $service, $room){
        $service->rooms()->attach($room);
        return redirect()->back()->with('message', "Has vinculado una habitación del servicio {$service->nombre}");
    }

    public function detach(Service $service, $room){
        $service->rooms()->detach($room);
        return redirect()->back()->with('message', "Has desvinculado una habitación del servicio {$service->nombre}");
    }
}
