<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Enterprise UX', 'color' => '#6366F1', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'Product Design', 'color' => '#E8FF47', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'Design Systems', 'color' => '#10B981', 'sort_order' => 3, 'is_active' => true],
            ['name' => '0→1 Products', 'color' => '#F59E0B', 'sort_order' => 4, 'is_active' => true],
            ['name' => 'Fintech', 'color' => '#3B82F6', 'sort_order' => 5, 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
