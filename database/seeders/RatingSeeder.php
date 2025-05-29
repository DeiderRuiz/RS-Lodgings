<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de los usuarios con el rol de cliente
        $clienteIds = User::role('cliente')->pluck('id')->toArray();
        Rating::factory()->count(500)->create([
            'users_id' => function () use ($clienteIds) {
                return fake()->randomElement($clienteIds);
            }
        ]);
    }
}
