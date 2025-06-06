<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'tutor')->first(); // pastikan ada tutor
        $category = Category::where('is_active', true)->first(); // pastikan ada category

        Service::create([
            'user_id' => $user->id ?? 1, // fallback ke id 1 kalau tidak ketemu
            'category_id' => $category->id ?? 1,
            'title' => 'Contoh Jasa Mengajar Laravel',
            'description' => 'Saya akan mengajari Laravel dengan pendekatan praktikal',
            'price' => 150000,
            'duration_days' => 7,
            'is_active' => true,
            'thumbnail' => 'services/thumbnails/dummy.png',
            'gallery' => [
                'services/gallery/dummy1.png',
                'services/gallery/dummy2.png'
            ]
        ]);
    }
}
