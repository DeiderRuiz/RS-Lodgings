<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Service;

class RoomServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::all();
        $services = Service::all();

        foreach ($rooms as $room) {
            $NumServicios = rand(1,10);
            $servicio = $services->random($NumServicios);
            $room->services()->attach($servicio);
        }
    }
}
