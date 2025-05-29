<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'tipo_de_oferta' => $this->faker->randomElement(['temporada', 'duración', 'especial']),
            'descripcion' => $this->faker->text(300),
            'descuento' => $this->faker->randomFloat(2, 0.1, 0.5),  // Descuento entre 10% y 50%
            'fecha_de_inicio' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'fecha_de_fin' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'noches_minimas' => $this->faker->numberBetween(1, 7),
            'vista' => 'https://picsum.photos/640/480',
        ];
    }
}
