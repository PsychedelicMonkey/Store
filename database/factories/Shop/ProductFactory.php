<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Product>
 */
class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->unique()->words(6, true),
            'slug' => Str::slug($name),
            'sku' => $this->faker->ean8(),
            'barcode' => $this->faker->ean13(),
            'description' => $this->faker->realText(),
            'qty' => $this->faker->randomDigitNotNull(),
            'security_stock' => $this->faker->randomDigitNotNull(),
            'featured' => $this->faker->boolean(),
            'is_visible' => $this->faker->boolean(),
            'old_price' => $this->faker->randomFloat(2, 100, 500),
            'price' => $this->faker->randomFloat(2, 80, 400),
            'cost' => $this->faker->randomFloat(2, 50, 200),
            'type' => $this->faker->randomElement(['deliverable', 'downloadable']),
            'published_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }

    public function configure(): ProductFactory
    {
        return $this->afterCreating(function (Product $product) {
            try {
                $product
                    ->addMediaFromUrl($this->faker->imageUrl())
                    ->preservingOriginal()
                    ->toMediaCollection('product-images');
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
