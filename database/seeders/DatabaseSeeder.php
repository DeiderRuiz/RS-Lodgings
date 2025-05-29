<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::factory()->create();
        
        $this->call([
            UserSeeder::class,
            DealSeeder::class,
            ServiceSeeder::class,
            RoomSeeder::class,
            RoomServiceSeeder::class,
            LocationSeeder::class,
            GalerySeeder::class,
            RatingSeeder::class,
            DealRoomSeeder::class,
            DealServiceSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
