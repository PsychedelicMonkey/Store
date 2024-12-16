<?php

namespace Database\Factories\Shop;

use App\Models\Shop\OrderAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\OrderAddress>
 */
class OrderAddressFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country' => strtolower($this->faker->countryCode()),
            'street' => $this->faker->streetAddress(),
            'state' => $this->faker->city(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
        ];
    }
}
