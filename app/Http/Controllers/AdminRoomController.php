<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminRoomController extends Controller
{
    public function index(){
        $rooms = Room::all()->map(function($room) {
            // Formateamos la fecha de creación y la pasamos a un formato de 12 horas
            $room->formatted_created_at = Carbon::parse($room->created_at)->format('m/d/Y h:i A');
            $room->formatted_updated_at = Carbon::parse($room->updated_at)->format('m/d/Y h:i A');
            return $room;
        });
        return Inertia::render('Admin/Rooms/Index', ['rooms'=>$rooms]);
    }

    public function show(Room $room){
        $room->formatted_created_at = Carbon::parse($room->created_at)->format('d/m/Y h:i A');
        $room->formatted_updated_at = Carbon::parse($room->updated_at)->format('d/m/Y h:i A');
        return Inertia::render('Admin/Rooms/Show', ['room'=>$room]);
    }

    public function create(){
        return Inertia::render('Admin/Rooms/Create', ['room'=> new Room]);
    }

    public function store(Request $request){
        $request->validate([
            'numero'=>['required', 'numeric', 'digits_between:1,4'],
            'tipo'=>['required', 'in:Individual,Doble,Suite'],
            'detalles' => ['required', 'string', 'max:300', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'vista'=>['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'precio'=>['required', 'numeric', 'digits:6'],
            'precio_huesped'=>['required', 'numeric', 'digits_between:4,5'],
            'precio_noche_extra'=>['required', 'numeric', 'digits_between:4,5'],
        ]);

        $path = $request->file('vista')->store('files', 'public');

        $room = new Room();
        $room->numero = $request->numero;
        $room->tipo = $request->tipo;
        $room->detalles = $request->detalles;
        $room->vista = Storage::url($path);
        $room->precio = $request->precio;
        $room->precio_huesped = $request->precio_huesped;
        $room->precio_noche_extra = $request->precio_noche_extra;
        $room->save();
        return redirect()->route('admin.rooms.show', ['room'=>$room->id])->with('message', "Has agregado la habitación N°{$room->numero} exitosamente.");
    }

    public function edit(Room $room){
        return Inertia::render('Admin/Rooms/Edit', ['room' => $room]);
    }

    public function update(Request $request, Room $room){
        $request->validate([
            'numero'=>['required', 'numeric', 'digits_between:1,4'],
            'tipo'=>['required', 'in:Individual,Doble,Suite'],
            'detalles' => ['required', 'string', 'max:3000', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'vista'=>['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'precio'=>['required', 'numeric', 'digits:6'],
            'precio_huesped'=>['required', 'numeric', 'digits_between:4,5'],
            'precio_noche_extra'=>['required', 'numeric', 'digits_between:4,5'],
        ]);

        $room->numero = $request->numero;
        $room->tipo = $request->tipo;
        $room->detalles = $request->detalles;
        if ($request->hasFile('vista')) {
            $path = $request->file('vista')->store('files', 'public');
            $room->vista = Storage::url($path);
        };
        $room->precio = $request->precio;
        $room->precio_huesped = $request->precio_huesped;
        $room->precio_noche_extra = $request->precio_noche_extra;
        $room->save();
        return redirect()->route('admin.rooms.show', ['room'=>$room->id])->with('message', "Has actualizado la habitación N°{$room->numero} exitosamente.");
    }

    public function destroy(Room $room){
        $numeroHabitacion = $room->numero;
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('message', "Has borrado la habitación N°{$numeroHabitacion} exitosamente.");
    }
}
