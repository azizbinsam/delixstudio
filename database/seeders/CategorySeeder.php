<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Course Categories
            ['name' => 'WordPress', 'slug' => 'wordpress', 'type' => 'course', 'icon' => 'fab fa-wordpress'],
            ['name' => 'Web Design', 'slug' => 'web-design', 'type' => 'course', 'icon' => 'fas fa-paint-brush'],
            ['name' => 'Plugin Development', 'slug' => 'plugin-development', 'type' => 'course', 'icon' => 'fas fa-plug'],

            // Product Categories
            ['name' => 'Tema WordPress', 'slug' => 'tema-wordpress', 'type' => 'product', 'icon' => 'fas fa-palette'],
            ['name' => 'Plugin WordPress', 'slug' => 'plugin-wordpress', 'type' => 'product', 'icon' => 'fas fa-puzzle-piece'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
