<?php

namespace Database\Factories;

use App\Models\ItemSet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemSet>
 */
class ItemSetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'short_name' => $this->faker->lexify('SET-????'),
            'long_name' => $this->faker->sentence(4),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'unit' => $this->faker->randomElement(['Set', 'Paket', 'Tag', 'Woche']),
        ];
    }
}
