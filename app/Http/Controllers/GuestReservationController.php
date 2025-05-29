<?php

namespace App\Http\Controllers;

use App\Jobs\SendReservationMail;
use App\Mail\CancelReservationMail;
use App\Mail\EditReservationMail;
use App\Mail\ReservationMail;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GuestReservationController extends Controller
{
    public function show(Reservation $reserva){
        $amount = $reserva->monto_habitacion + $reserva->monto_extra_huesped + $reserva->monto_noche_extra + $reserva->monto_servicios;
        $response = Http::get('https://api.exchangerate-api.com/v4/latest/COP');
        $rate = $response->json()['rates']['USD'];
        $converted = $amount * $rate;
        return Inertia::render('Reservations/Show', [
            'reserva' => $reserva->load('guest', 'rooms', 'service'), 
            'amount' => round($converted, 2),
        ]);
    }

    public function store(Request $request, Room $room){

        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:8,12'],
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'cellphone' => ['required', 'numeric', 'digits_between:10,15'],
            'email' => ['required', 'string', 'email', 'max:40'],
            'fecha_inicio'=>['required', 'date'],
            'fecha_fin'=>['required', 'date', 'after_or_equal:fecha_inicio'],
            'huespedes'=>['required', 'numeric'],
        ]);

        DB::statement("
            INSERT INTO guests (cedula, name, last_name, cellphone, email, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
              name = VALUES(name),
              last_name = VALUES(last_name),
              cellphone = VALUES(cellphone),
              email = VALUES(email),
              updated_at = NOW()
        ", [
            $request->cedula,
            $request->name,
            $request->last_name,
            $request->cellphone,
            $request->email,
        ]);
        $guest = Guest::where('cedula', $request->cedula)->first(); // opcional si lo necesitas luego


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
            'guest_id' => $guest->id,
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

        SendReservationMail::dispatch($reservation->load('guest', 'rooms', 'service'));

        return redirect()->route('guest.reservations.show', ['reserva'=>$reservation->uuid])->with('message', 'Has realizado una solicitud de reservación.');
    }

    public function cancel(Reservation $reserva){
        $reserva->estado = 'cancelado';
        $reserva->save();

        $room = $reserva->rooms->first();

        if ($room && $room->disponibilidad === 0) {
            $room->update(['disponibilidad' => 1]);
        }

        SendReservationMail::dispatch($reserva->load('guest', 'rooms', 'service'));

        return redirect()->route('guest.reservations.show', ['reserva'=>$reserva->uuid])->with('message', 'Has cancelado la solicitud de reservación.');
    }

    public function update(Request $request, Reservation $reserva, Room $room){
        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:8,12'],
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'cellphone' => ['required', 'numeric', 'digits_between:10,15'],
            'email' => ['required', 'string', 'email', 'max:40'],
            'fecha_inicio'=>['required', 'date'],
            'fecha_fin'=>['required', 'date', 'after_or_equal:fecha_inicio'],
            'huespedes'=>['required', 'numeric'],
        ]);

        $guest = Guest::updateOrCreate(
            ['cedula' => $request->cedula], // Condición para encontrar el registro
            [ // Datos a actualizar o crear
                'name' => $request->name,
                'last_name' => $request->last_name,
                'cellphone' => $request->cellphone,
                'email' => $request->email,
            ]
        );

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
            'guest_id' => $guest->id,
        ]);

        $servicios = collect($request->input('servicios', []))->filter()->keys();

        $reserva->service()->sync($servicios);

        SendReservationMail::dispatch($reserva->load('guest', 'rooms', 'service'));

        return redirect()->route('guest.reservations.show', ['reserva'=>$reserva->uuid])->with('message', 'Has actualizado tu solicitud de reservación.');
    }
}
