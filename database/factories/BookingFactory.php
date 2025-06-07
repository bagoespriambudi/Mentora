<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'session_id' => \App\Models\Session::inRandomOrder()->first()?->id,
            'tutee_id' => User::factory(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional()->sentence(10),
            'scheduled_at' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
        ];
    }
} 