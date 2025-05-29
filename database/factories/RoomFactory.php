<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero' => $this->faker->numerify('###'),
            'tipo' => $this->faker->randomElement(['Individual', 'Doble', 'Suite']),
            'detalles' => $this->faker->text(300),
            /* 'vista' => $this->faker->imageUrl(640, 480, 'hotel', true, 'Faker'), */
            /* 'vista' => 'https://source.unsplash.com/random/640x480?hotel,room&sig=' . $this->faker->unique()->randomNumber(), */
            'vista' => 'https://picsum.photos/640/480',
            'precio' => $this->faker->randomFloat(0, 50000, 500000),
            'precio_huesped' => $this->faker->randomFloat(0, 50000, 100000),
            'precio_noche_extra' => $this->faker->randomFloat(0, 50000, 100000),
        ];
    }
}
