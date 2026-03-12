<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'short_name' => $this->faker->lexify('??????????'),
            'long_name' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(),
            'has_dry_hire_option' => $this->faker->boolean(),
            'unit' => $this->faker->randomElement(['Stk', 'Tag', 'Woche', 'Set', 'm', 'kg']),
        ];
    }
}
