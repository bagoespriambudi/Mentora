<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Web development services including frontend, backend, and full-stack development',
                'is_active' => true,
            ],
            [
                'name' => 'Graphic Design',
                'description' => 'Graphic design services including logos, branding, and illustrations',
                'is_active' => true,
            ],
            [
                'name' => 'Content Writing',
                'description' => 'Content writing services including blog posts, articles, and copywriting',
                'is_active' => true,
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Digital marketing services including SEO, social media, and email marketing',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
