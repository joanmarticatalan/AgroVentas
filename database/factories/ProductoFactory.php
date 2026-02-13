<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement(['Tomate', 'Lechuga', 'Manzana', 'Trigo']),
            'variedad' => fake()->word(),
            'stock' => $this->faker->numberBetween(10, 500),
            'precio' => $this->faker->randomFloat(2, 5, 500),
            'fechaProduccion' => fake()->date(),
            'imagen' => 'productos/default.jpg',
        ];
    }
}
