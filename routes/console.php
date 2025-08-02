<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register the site settings seed command
use App\Models\SiteSetting;

Artisan::command('site:seed-settings', function () {
    $this->info('Seeding site settings...');

    // Add the new organization location and establishment settings
    $newSettings = [
        [
            'key' => 'organization_location',
            'value' => 'काठमाडौं, नेपाल',
            'type' => 'text',
            'group' => 'brand',
            'label' => 'Organization Location',
            'description' => 'Location text displayed in the header below the site title',
            'sort_order' => 9,
        ],
        [
            'key' => 'organization_establishment',
            'value' => 'स्थापना: २०४६ साल',
            'type' => 'text',
            'group' => 'brand',
            'label' => 'Organization Establishment',
            'description' => 'Establishment text displayed in the header below the site title',
            'sort_order' => 10,
        ],
    ];

    foreach ($newSettings as $setting) {
        SiteSetting::updateOrCreate(
            ['key' => $setting['key']],
            $setting
        );
        $this->info("Added/Updated setting: {$setting['key']}");
    }

    $this->info('Site settings seeded successfully!');
})->purpose('Seed site settings with default values');
