<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ServiceFactory extends Factory
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
            'tipo' => $this->faker->randomElement([
                'actividades', 'alimentacion', 'alojamiento', 'instalaciones','servicios adicionales'
            ]), // Tipo aleatorio
            'para_habitacion' => $this->faker->boolean,
            'detalles' => $this->faker->text(300),
            'precio' => $this->faker->randomFloat(0, 10000, 100000),
        ];
    }
}
