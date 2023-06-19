<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_code' => 'IC-1000-' . substr('0000'.rand(100, 5000), -4),
            'description' => 'Name of Product ' . substr('0000'.rand(100, 5000), -4),
            'unit_price' => mt_rand(100, 1000),
        ];
    }
}
