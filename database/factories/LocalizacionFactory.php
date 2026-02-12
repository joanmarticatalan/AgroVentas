<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Localizacion>
 */
class LocalizacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    
    public function definition(): array
    {
        return [
        'provincia' => fake()->state(),
        'codigoPostal' => fake()->numerify('#####'),
        'nombreCalle' => fake()->streetName(),
        'numero' => fake()->buildingNumber(),
        'puerta' => fake()->bothify('?#'),
    ];
    }
}
