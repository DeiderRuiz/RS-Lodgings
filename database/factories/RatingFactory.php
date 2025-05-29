<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'users_id'=> null,
            'locations_id'=> $this->faker->numberBetween(1, 10),
            'calificacion'=>$this->faker->numberBetween(3, 5),
            'review' => $this->faker->text(500),
        ];
    }
}
