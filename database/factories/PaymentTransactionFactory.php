<?php

namespace Database\Factories;

use App\Models\PaymentTransaction;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTransactionFactory extends Factory
{
    protected $model = PaymentTransaction::class;

    public function definition()
    {
        $amount = $this->faker->randomFloat(2, 10000, 500000);
        return [
            'user_id' => User::factory(),
            'tutor_id' => User::factory(),
            'session_id' => Service::factory(),
            'amount' => $amount,
            'payment_method' => $this->faker->randomElement(['bank', 'ewallet', 'cash']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'refunded']),
            'transaction_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'payment_proof' => null,
        ];
    }
} 