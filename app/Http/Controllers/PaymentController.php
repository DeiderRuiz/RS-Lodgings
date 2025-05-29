<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function RealizarPago(Reservation $reserva){

        $reserva->load('user', 'guest', 'rooms', 'service');
        
        if ($reserva->estado == 'pendiente') {
            $total = (float) (
                $reserva->monto_habitacion +
                $reserva->monto_extra_huesped +
                $reserva->monto_noche_extra +
                $reserva->monto_servicios
            );
    

            if ($reserva->user) {
                Payment::create([
                    'monto_total' => $total,
                    'fecha_pago' => now(),
                    'estado' => 'pagado',
                    'user_id' => $reserva->user->id,
                    'reservation_id' => $reserva->id,
                ]);
            }else {
                Payment::create([
                    'monto_total' => $total,
                    'fecha_pago' => now(),
                    'estado' => 'pagado',
                    'guest_id' => $reserva->guest->id,
                    'reservation_id' => $reserva->id,
                ]);
            }

            $reserva->update(['estado' => 'pagado']);
        }

        return redirect()->back()->with('message', 'Su reserva ha sido pagada y confirmada correctamente');
    }
}
