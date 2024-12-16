<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'birthday' => $this->faker->dateTimeBetween('-35 years', '-18 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }
}
