<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $posts = Post::all();

        // Create sample comments
        foreach ($posts as $post) {
                Comment::factory()->count(3)->create([
                    'post_id' => $post->id,
                ]);

        }
    }
}
