<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => fake()->dateTimeBetween('-1 month', 'now'),
            'tipoEnvio' => fake()->randomElement(['A recoger', 'EnvioCasa']),
            'precio_total' => 0, // Se actualizará en el Seeder tras sumar las líneas
            // user_id y localizacion_id se pasan desde el Seeder
        ];
    }
}
