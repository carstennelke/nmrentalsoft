<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    public function definition(): array
    {
        $isCompany = $this->faker->boolean(40);

        return [
            'is_company' => $isCompany,
            'title' => $isCompany ? null : $this->faker->randomElement([null, 'Herr', 'Frau', 'Dr.', 'Prof.']),
            'name' => $isCompany ? null : $this->faker->firstName(),
            'lastname' => $isCompany ? null : $this->faker->lastName(),
            'company_name' => $isCompany ? $this->faker->company() : null,
            'email' => $this->faker->optional(0.8)->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'street' => $this->faker->streetAddress(),
            'zip' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'vat' => $isCompany ? $this->faker->optional(0.5)->numerify('DE###########') : null,
        ];
    }
}
