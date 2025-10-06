<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'fruits',
                'persian_name' => 'میوه‌ها',
                'description' => 'Learn the names of different fruits in Persian'
            ],
            [
                'name' => 'animals',
                'persian_name' => 'حیوانات',
                'description' => 'Learn the names of different animals in Persian'
            ],
            [
                'name' => 'numbers',
                'persian_name' => 'اعداد',
                'description' => 'Learn numbers in Persian'
            ],
            [
                'name' => 'shapes',
                'persian_name' => 'اشکال',
                'description' => 'Learn the names of different shapes in Persian'
            ],
            [
                'name' => 'colors',
                'persian_name' => 'رنگ‌ها',
                'description' => 'Learn the names of different colors in Persian'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
