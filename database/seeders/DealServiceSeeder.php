<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deals = Deal::all();
        $services = Service::all();

        foreach ($deals as $deal) {
            $numServicios = rand(1,10);
            $servicio = $services->random($numServicios);
            $deal->services()->attach($servicio);
        }
    }
}
