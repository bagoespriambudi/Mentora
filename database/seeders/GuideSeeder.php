<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guide::create([
            'title' => 'Getting Started with the Platform',
            'content' => '<p>This guide helps you get started by explaining the basic features and layout of the platform.</p>',
        ]);

        Guide::create([
            'title' => 'Managing Your Profile',
            'content' => '<p>Learn how to update your profile, change your photo, and set preferences.</p>',
        ]);
    }
}
