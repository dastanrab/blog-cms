<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(3, true),
            'publish_status' => $this->faker->randomElement(config('app.publish_statuses')),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $post->categories()->attach($categories);
        });
    }
}
