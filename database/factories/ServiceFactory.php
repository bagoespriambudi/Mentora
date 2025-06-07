<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        return [
            'tutor_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'price' => $this->faker->randomFloat(2, 10000, 500000),
            'duration_days' => $this->faker->numberBetween(1, 14),
            'is_active' => $this->faker->boolean(90),
            'thumbnail' => null,
            'gallery' => null,
        ];
    }
} 