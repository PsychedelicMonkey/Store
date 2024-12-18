<?php

namespace Database\Factories\Blog;

use App\Enums\PostStatus;
use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog\Post>
 */
class PostFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->unique()->words(6, true),
            'slug' => Str::slug($title),
            'content' => $this->faker->realText(),
            'published_at' => $this->faker->dateTimeBetween('-1 year', '+1 month'),
            'status' => $this->faker->randomElement(PostStatus::class),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }

    public function configure(): PostFactory
    {
        return $this->afterCreating(function (Post $post) {
            try {
                $post
                    ->addMediaFromUrl($this->faker->imageUrl())
                    ->preservingOriginal()
                    ->toMediaCollection('post-images');
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
