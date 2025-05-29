<?php

namespace App\Http\Controllers;

use App\Jobs\SendReservationMail;
use App\Mail\CancelReservationMail;
use App\Mail\EditReservationMail;
use App\Mail\ReservationMail;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Service;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index(){
        $user = auth()->user();
        $reservas = Reservation::with(['user', 'rooms'])->where('user_id', $user->id)->get();
        return Inertia::render('Customers/Reservations/Index', ['reservas' => $reservas]);
    }
    
    public function show(Reservation $reserva){
        $this->authorize('view', $reserva);
        $amount = $reserva->monto_habitacion + $reserva->monto_extra_huesped + $reserva->monto_noche_extra + $reserva->monto_servicios;
        $response = Http::get('https://api.exchangerate-api.com/v4/latest/COP');
        $rate = $response->json()['rates']['USD'];
        $converted = $amount * $rate;
        return Inertia::render('Customers/Reservations/Show', [
            'reserva' => $reserva->load('user', 'rooms', 'service'),
            'amount' => round($converted, 2),
        ]);
    }

    public function create(Room $room){
        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;
        $room = Room::with('services')->find($room->id);
        //Se trae al resto de servicios
        $services = Service::where('para_habitacion', false)->get();
        $reserva = new Reservation;

        return match ($role) {
            3 => Inertia::render('Customers/Reservations/Create', ['reserva' => $reserva, 'room' => $room, 'services' => $services]),
            null => Inertia::render('Reservations/Create', ['reserva' => $reserva, 'room' => $room, 'services' => $services]),
            default => redirect()->route('index'),
        };
    }

    public function store(Request $request, Room $room){

        $request->validate([
            'fecha_inicio'=>['required', 'date'],
            'fecha_fin'=>['required', 'date', 'after_or_equal:fecha_inicio'],
            'huespedes'=>['required', 'numeric'],
        ]);

        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin);
        $totalServicios = Service::whereIn('id', array_keys($request->input('servicios', [])))->sum('precio');

        $reservation = Reservation::create([
            'uuid' => Str::uuid(),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'huespedes' => $request->huespedes,
            'noches' => $fecha_inicio->diffInDays($fecha_fin),
            'monto_habitacion' => $room->precio,
            'monto_extra_huesped' => $room->precio_huesped * max(0, $request->huespedes - 1),
            'monto_noche_extra' => $room->precio_noche_extra * max(0, $fecha_inicio->diffInDays($fecha_fin) - 1),
            'monto_servicios' => $totalServicios,
            'estado' => 'pendiente',
            'user_id' => auth()->id(),
        ]);

        /* $reservation->service()->attach(array_keys(request('servicios', []))); */
        $servicios = collect(request('servicios', []))->filter()->keys();
        $reservation->service()->attach($servicios);
        // Relacionar habitación con la reserva
        $reservation->rooms()->attach($room->id);

        // Actualizar el campo 'disponibilidad' en la tabla 'rooms'
        if ($room->disponibilidad === 1) {
            $room->update(['disponibilidad' => 0]);
        }

        SendReservationMail::dispatch($reservation->load('user', 'rooms', 'service'));

        return redirect()->route('customer.reservations.show', ['reserva'=>$reservation->uuid])->with('message', 'Has realizado una solicitud de reservación.');
    }

    public function cancel(Reservation $reserva){
        $reserva->estado = 'cancelado';
        $reserva->save();

        $room = $reserva->rooms->first();

        if ($room && $room->disponibilidad === 0) {
            $room->update(['disponibilidad' => 1]);
        }

        SendReservationMail::dispatch($reserva->load('user', 'rooms', 'service'));

        return redirect()->route('customer.reservations.show', ['reserva'=>$reserva->uuid])->with('message', 'Has cancelado la solicitud de reservación.');
    }

    public function edit(Reservation $reserva){
        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;
        // Cargar relaciones antes de usar los datos
        $reserva->load('rooms.services', 'user', 'guest', 'service');
        // Obtener la habitación desde la reserva
        $room = $reserva->rooms->first();
    
        // Obtener servicios exclusivos de la habitación con Eloquent
        $exclusive_services = $room?->services()
            ->where('para_habitacion', true)
            ->get(['services.id', 'nombre', 'tipo', 'precio']) ?? collect();

        // Obtener servicios generales directamente con Eloquent
        $services = Service::where('para_habitacion', false)->get();
        
        return match ($role) {
            3 => Inertia::render('Customers/Reservations/Edit', [
                'room' => $room, 'reserva' => $reserva, 
                'exclusive_services' => $exclusive_services, 'services' => $services,
            ]),
            null => Inertia::render('Reservations/Edit', [
                'room' => $room, 'reserva' => $reserva, 
                'exclusive_services' => $exclusive_services, 'services' => $services,
            ]),
            default => redirect()->route('index'),
        };
    }
    

    public function update(Request $request, Reservation $reserva, Room $room){
        $request->validate([
            'fecha_inicio'=>['required', 'date'],
            'fecha_fin'=>['required', 'date', 'after_or_equal:fecha_inicio'],
            'huespedes'=>['required', 'numeric'],
        ]);

        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin);
        $totalServicios = Service::whereIn('id', array_keys($request->input('servicios', [])))->sum('precio');

        $reserva->update([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'huespedes' => $request->huespedes,
            'noches' => $fecha_inicio->diffInDays($fecha_fin),
            'monto_habitacion' => $room->precio,
            'monto_extra_huesped' => $room->precio_huesped * max(0, $request->huespedes - 1),
            'monto_noche_extra' => $room->precio_noche_extra * max(0, $fecha_inicio->diffInDays($fecha_fin) - 1),
            'monto_servicios' => $totalServicios,
            'estado' => 'pendiente',
            'user_id' => auth()->id(),
        ]);

        $servicios = collect($request->input('servicios', []))->filter()->keys();

        $reserva->service()->sync($servicios);

        SendReservationMail::dispatch($reserva->load('user', 'rooms', 'service'));

        return redirect()->route('customer.reservations.show', ['reserva'=>$reserva->uuid])->with('message', 'Has actualizado tu solicitud de reservación.');
    }
}
