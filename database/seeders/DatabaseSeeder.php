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
            FaqSeeder::class,
            GuideSeeder::class,
            PolicySeeder::class,
        ]);
        $this->call(ContentSeeder::class);
    }
}
