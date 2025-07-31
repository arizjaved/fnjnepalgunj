<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsCategory;
use App\Models\User;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $adminUser = User::first(); // Get first admin user
        
        if (!$adminUser) {
            $this->command->error('No admin user found. Please create an admin user first.');
            return;
        }

        $categories = [
            [
                'name' => 'संस्थागत',
                'description' => 'संस्थागत समाचार र घटनाहरू',
                'color' => '#0073b7',
                'sort_order' => 1,
            ],
            [
                'name' => 'कार्यक्रम',
                'description' => 'विभिन्न कार्यक्रमहरूका समाचार',
                'color' => '#16a34a',
                'sort_order' => 2,
            ],
            [
                'name' => 'तालिम',
                'description' => 'तालिम र क्षमता विकास सम्बन्धी समाचार',
                'color' => '#dc2626',
                'sort_order' => 3,
            ],
            [
                'name' => 'सम्मेलन',
                'description' => 'सम्मेलन र बैठकका समाचार',
                'color' => '#7c3aed',
                'sort_order' => 4,
            ],
            [
                'name' => 'अभियान',
                'description' => 'विभिन्न अभियान र आन्दोलनका समाचार',
                'color' => '#ea580c',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            NewsCategory::create([
                'name' => $categoryData['name'],
                'slug' => \Illuminate\Support\Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'color' => $categoryData['color'],
                'is_active' => true,
                'sort_order' => $categoryData['sort_order'],
                'created_by' => $adminUser->id,
            ]);
        }

        $this->command->info('News categories seeded successfully!');
    }
}