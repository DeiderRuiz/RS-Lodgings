<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $ciudades = [
            'Valledupar',
            'Pasto',
            'Quindío',
            'Medellín',
            'Cucuta',
            'Bucaramanga',
            'Barranquilla',
            'Pereira',
            'Santa Marta',
            'Cartagena',
            'Cali',
            'Bogotá',
        ];

        // Si ya se han usado todas las ciudades, las mezclamos de nuevo
        if (empty($ciudades)) {
            shuffle($ciudades);
        }

        // Obtenemos y eliminamos la última ciudad del array
        $ciudad = array_pop($ciudades);

        return [
            'ciudad' => $ciudad,
            'direccion' => $this->faker->word,
            'url'=>Str::limit($this->faker->url, 30, ''),
            'cellphone_hotel'=> $this->faker->numerify('##########'),
            'descripcion' => $this->faker->text(1000),
            /* 'portada' => 'https://source.unsplash.com/random/500x500?hotel&sig=' . $this->faker->unique()->randomNumber(), */ // Genera una URL de imagen aleatoria de Unsplash
            'portada' => 'https://picsum.photos/500/500'
        ];
    }
}
