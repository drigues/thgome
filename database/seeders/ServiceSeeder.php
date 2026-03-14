<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Product Design',
                'icon' => '◈',
                'description' => 'End-to-end product design — from discovery and strategy through wireframes, prototypes, and pixel-perfect UI. I design systems that scale, not just screens that look good.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'UX Research',
                'icon' => '◉',
                'description' => 'User interviews, usability testing, journey mapping, and data analysis. I turn qualitative and quantitative insights into design decisions that move metrics.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Design Systems',
                'icon' => '⬡',
                'description' => 'Token-based design systems with component libraries, documentation, and governance. Built to bridge the gap between design tools and production code.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'UX Audit',
                'icon' => '◎',
                'description' => 'Heuristic evaluation, accessibility audits (WCAG 2.1), and competitive analysis. I identify friction points and deliver actionable recommendations with clear priority.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'AI-augmented Design',
                'icon' => '◆',
                'description' => 'Integrating AI capabilities into product experiences — from prompt engineering to designing human-in-the-loop workflows that feel natural, not forced.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Technical Product Consulting',
                'icon' => '◇',
                'description' => 'Strategic guidance on design-engineering alignment, front-end architecture decisions, and design operations. I speak both languages fluently.',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['title' => $service['title']], $service);
        }
    }
}
