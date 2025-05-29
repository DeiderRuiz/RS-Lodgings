<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deals = Deal::all();
        $rooms = Room::all();

        foreach ($deals as $deal) {
            $numHabitaciones = rand(1,30);
            $habitacion = $rooms->random($numHabitaciones);
            $deal->rooms()->attach($habitacion);
        }
    }
}
