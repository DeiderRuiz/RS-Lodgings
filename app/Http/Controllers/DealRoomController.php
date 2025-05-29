<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DealRoomController extends Controller
{
    public function show(Deal $deal){
        $rooms = Room::get();
        $attached_rooms = $deal->rooms->pluck('id')->ToArray();
        return Inertia::render('Admin/DealRoom/Show', [
            'deal' => $deal,
            'rooms' => $rooms,
            'attached_rooms' => $attached_rooms,
        ]);
    }

    public function attach(Deal $deal, $room){
        $deal->rooms()->attach($room);
        return redirect()->back()->with('message', "Has vinculado una habitación a la oferta {$deal->nombre}");
    }

    public function detach(Deal $deal, $room){
        $deal->rooms()->detach($room);
        return redirect()->back()->with('message', "Has desvinculado una habitación a la oferta {$deal->nombre}");
    }
}
