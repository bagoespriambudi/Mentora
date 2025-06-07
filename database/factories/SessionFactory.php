<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition()
    {
        return [
            'tutor_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10000, 500000),
            'duration_days' => $this->faker->numberBetween(1, 14),
            'thumbnail' => null,
            'gallery' => null,
            'is_active' => $this->faker->boolean(90),
            'schedule' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
} 