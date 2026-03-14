<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Chen',
                'role' => 'VP of Product',
                'company' => 'McKesson',
                'content' => 'Thiago brought a rare combination of design craft and engineering awareness. He didn\'t just design screens — he designed systems that our developers could actually build and maintain at scale.',
                'rating' => 5,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Marcus Andersen',
                'role' => 'CTO',
                'company' => 'BladeInsight',
                'content' => 'The design system Thiago built became the backbone of our entire product suite. His ability to think in components and tokens while never losing sight of the user experience is exceptional.',
                'rating' => 5,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Emily Roberts',
                'role' => 'Head of Design',
                'company' => 'MindTools',
                'content' => 'Working with Thiago was a masterclass in research-led design. He challenged assumptions with data, prototyped relentlessly, and shipped features that moved our engagement metrics significantly.',
                'rating' => 5,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(['name' => $testimonial['name']], $testimonial);
        }
    }
}
