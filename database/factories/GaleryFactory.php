<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galery>
 */
class GaleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'locations_id'=> $this->faker->numberBetween(1, 10),
            /* 'imagen' => 'https://source.unsplash.com/random/2048x1024?hotel&sig=' . $this->faker->unique()->randomNumber(), */
            'imagen' => 'https://picsum.photos/2048/1024'
        ];
    }
}
