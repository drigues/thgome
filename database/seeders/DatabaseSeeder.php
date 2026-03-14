<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([UserSeeder::class]);
        $this->command->info('✓ Users');

        $this->call([SettingSeeder::class]);
        $this->command->info('✓ Settings');

        $this->call([CategorySeeder::class]);
        $this->command->info('✓ Categories');

        $this->call([ProjectSeeder::class]);
        $this->command->info('✓ Projects');

        $this->call([ServiceSeeder::class]);
        $this->command->info('✓ Services');

        $this->call([TestimonialSeeder::class]);
        $this->command->info('✓ Testimonials');
    }
}
