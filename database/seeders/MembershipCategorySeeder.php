<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipCategory;

class MembershipCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'अध्यक्ष',
                'slug' => 'president',
                'description' => 'नेपाल पत्रकार महासंघको अध्यक्ष',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'वरिष्ठ उपाध्यक्ष',
                'slug' => 'senior-vice-president',
                'description' => 'नेपाल पत्रकार महासंघको वरिष्ठ उपाध्यक्ष',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'उपाध्यक्षहरू',
                'slug' => 'vice-presidents',
                'description' => 'नेपाल पत्रकार महासंघका उपाध्यक्षहरू',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'महासचिव',
                'slug' => 'general-secretary',
                'description' => 'नेपाल पत्रकार महासंघको महासचिव',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'सचिव',
                'slug' => 'secretary',
                'description' => 'नेपाल पत्रकार महासंघको सचिव',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'कोषाध्यक्ष',
                'slug' => 'treasurer',
                'description' => 'नेपाल पत्रकार महासंघको कोषाध्यक्ष',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'केन्द्रीय सदस्यहरू',
                'slug' => 'central-members',
                'description' => 'नेपाल पत्रकार महासंघका केन्द्रीय सदस्यहरू',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            MembershipCategory::create($categoryData);
        }
    }
}