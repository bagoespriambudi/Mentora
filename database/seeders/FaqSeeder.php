<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'title' => 'How do I register?',
            'content' => '<p>You can register by clicking on the register button and filling out the form.</p>',
        ]);

        Faq::create([
            'title' => 'How do I reset my password?',
            'content' => '<p>Click on "Forgot Password" on the login page and follow the instructions.</p>',
        ]);
    }
}
