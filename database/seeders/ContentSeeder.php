<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        Content::create([
            'title' => 'How to Book a Session',
            'type' => 'guide',
            'order' => 1,
            'body' => 'To book a session, simply browse available tutors and click the "Book" button on their profile.',
            'content' => 'To book a session, simply browse available tutors and click the "Book" button on their profile.',
            'is_active' => true,
        ]);
        Content::create([
            'title' => 'Payment & Refund Policy',
            'type' => 'policy',
            'order' => 2,
            'body' => 'All payments are processed securely. Refunds are available under certain conditions. Please read our full policy.',
            'content' => 'All payments are processed securely. Refunds are available under certain conditions. Please read our full policy.',
            'is_active' => true,
        ]);
        Content::create([
            'title' => 'Frequently Asked Questions',
            'type' => 'faq',
            'order' => 3,
            'body' => 'Q: How do I become a tutor?\nA: Register and complete your profile, then apply as a tutor.',
            'content' => 'Q: How do I become a tutor?\nA: Register and complete your profile, then apply as a tutor.',
            'is_active' => true,
        ]);
    }
} 