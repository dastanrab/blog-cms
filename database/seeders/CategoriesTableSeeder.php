<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = ['Technology', 'Science', 'Health', 'Business', 'Entertainment'];
        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }
    }
}
