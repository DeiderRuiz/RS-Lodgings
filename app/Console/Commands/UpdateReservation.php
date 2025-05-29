<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;

class UpdateReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reservas = Reservation::with(['rooms'])->where('fecha_fin', '<', now())
            ->whereIn('estado', ['pendiente', 'pagada'])
            ->get();

        
        foreach ($reservas as $reserva) {
            $reserva->update(['estado' => 'finalizado']);
            foreach ($reserva->rooms as $room) {
                $room->update(['disponibilidad' => true]);
            }        
        }

        $this->info('Reservas actualizadas correctamente.');        

    }
}
