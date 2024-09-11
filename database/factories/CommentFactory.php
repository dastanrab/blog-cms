<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        $statuses=['Approve','Reject'];
        return [
            'text' => $this->faker->sentence,
            'status' => $this->faker->randomElement($statuses), // 80% chance of being approved
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
