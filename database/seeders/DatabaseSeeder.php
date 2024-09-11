<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name'=>'dastan','password'=>Hash::make(12345),'email'=>'dastanrab@gmail.com','role'=>'Admin'
        ]);
        $this->call([ CategoriesTableSeeder::class,
            PostsTableSeeder::class,
            CommentsTableSeeder::class,]);

    }
}
