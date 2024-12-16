<?php

namespace Database\Seeders;

use App\Models\Blog\Author;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Post;
use App\Models\Shop\Brand;
use App\Models\Shop\Category as ShopCategory;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Product;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Shop
        $brands = Brand::factory(20)->create();

        $categories = ShopCategory::factory(20)
            ->has(
                ShopCategory::factory()->count(3),
                'children'
            )
            ->create();

        $customers = Customer::factory(1000)->create();

        $products = Product::factory(50)
            ->sequence(fn ($sequence) => ['shop_brand_id' => $brands->random(1)->first()->id])
            ->hasAttached($categories->random(rand(3, 6)), ['created_at' => now(), 'updated_at' => now()])
            ->create();

        $orders = Order::factory(1000)
            ->sequence(fn ($sequence) => ['shop_customer_id' => $customers->random(1)->first()->id])
            ->has(
                OrderItem::factory()->count(rand(2, 5))
                    ->state(fn (array $attributes, Order $order) => ['shop_product_id' => $products->random(1)->first()->id]),
                'items'
            )
            ->create();

        // Blog
        $blogCategories = BlogCategory::factory(20)->create();

        Author::factory(20)
            ->has(
                Post::factory(5)
                    ->state(fn (array $attributes, Author $author) => ['blog_category_id' => $blogCategories->random(1)->first()->id]),
                'posts'
            )
            ->create();
    }
}
