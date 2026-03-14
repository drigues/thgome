<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Geral
            'site_name' => 'Thiago Rodrigues',
            'site_tagline' => 'Product Designer · 10+ years',
            'site_description' => 'Product Designer with 10+ years of experience turning complex challenges into clear, purposeful digital products.',
            'contact_email' => 'hello@thgo.me',
            'contact_phone' => '+351 912 345 678',
            'address' => 'Lisbon, Portugal',

            // Redes Sociais
            'social_instagram' => 'https://instagram.com/thgo.design',
            'social_linkedin' => 'https://linkedin.com/in/thiagorodrigues',
            'social_github' => 'https://github.com/thgo',
            'social_behance' => 'https://behance.net/thgo',
            'social_dribbble' => 'https://dribbble.com/thgo',

            // Homepage
            'hero_title' => "Product\nDesigner.",
            'hero_subtitle' => 'Turning complex challenges into clear, purposeful digital products.',
            'hero_cta_text' => 'View Work',

            // Sobre
            'about_title' => 'Designer. Builder. Systems thinker.',
            'about_text' => '<p>I\'m Thiago Rodrigues — a Product Designer with 10+ years of experience turning complex challenges into clear, purposeful digital products.</p><p>I\'ve led end-to-end design for enterprise SaaS, fintech, and healthcare platforms — shipping products used by thousands. My approach blends systems thinking with hands-on prototyping and a deep understanding of front-end engineering.</p><p>Currently based in Portugal, working remotely across time zones.</p>',

            // SEO
            'seo_title_suffix' => '— Thiago Rodrigues · Product Designer',
            'google_analytics_id' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
