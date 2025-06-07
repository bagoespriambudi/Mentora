<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'tutee_id' => User::factory(),
            'tutor_id' => User::factory(),
            'session_id' => Service::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->sentence(12),
            'response' => $this->faker->optional()->sentence(8),
        ];
    }
} 