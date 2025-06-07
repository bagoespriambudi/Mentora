<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            // FaqSeeder::class,
            // GuideSeeder::class,
            // PolicySeeder::class,
        ]);
        // $this->call(ContentSeeder::class);
        \App\Models\Content::factory()->count(6)->create([
            'is_active' => true,
        ]);
        \App\Models\Session::factory()->count(5)->create();
        // Add review, payment, and booking seeders
        \App\Models\Review::factory()->count(10)->create();
        \App\Models\PaymentTransaction::factory()->count(10)->create();
        \App\Models\Booking::factory()->count(10)->create();

        // --- Custom: Seed finished bookings for tutee ---
        $tutee = \App\Models\User::where('role', 'tutee')->first();
        $sessions = \App\Models\Session::inRandomOrder()->take(3)->get();
        foreach ($sessions as $session) {
            \App\Models\Booking::create([
                'session_id' => $session->id,
                'tutee_id' => $tutee->id,
                'status' => 'finished',
                'notes' => 'Auto-generated finished booking for review testing.',
                'scheduled_at' => now()->subDays(rand(1, 30)),
            ]);
        }
        // --- End Custom ---
    }
}
