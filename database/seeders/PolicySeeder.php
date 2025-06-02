<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Policy::create([
            'title' => 'Privacy Policy',
            'content' => '<p>We take your privacy seriously. This document outlines how we use and protect your data.</p>',
        ]);

        Policy::create([
            'title' => 'Terms of Service',
            'content' => '<p>By using this platform, you agree to comply with our terms and conditions.</p>',
        ]);
    }
}
