<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaultSettings = [
            // Brand & Identity Settings
            [
                'key' => 'site_name',
                'value' => 'नेपाल पत्रकार महासंघ',
                'type' => 'text',
                'group' => 'brand',
                'label' => 'Site Name',
                'description' => 'The name of your website',
                'sort_order' => 1,
            ],
            [
                'key' => 'site_name_english',
                'value' => 'Federation of Nepali Journalists',
                'type' => 'text',
                'group' => 'brand',
                'label' => 'Site Name (English)',
                'description' => 'The English name of your website',
                'sort_order' => 2,
            ],
            [
                'key' => 'site_tagline',
                'value' => 'स्थापना: २०४६ साल',
                'type' => 'text',
                'group' => 'brand',
                'label' => 'Site Tagline/Slogan',
                'description' => 'A short description or tagline for your site',
                'sort_order' => 3,
            ],
            [
                'key' => 'primary_color',
                'value' => '#0073b7',
                'type' => 'color',
                'group' => 'brand',
                'label' => 'Primary Color',
                'description' => 'Main brand color used throughout the site',
                'sort_order' => 6,
            ],
            [
                'key' => 'secondary_color',
                'value' => '#004a7f',
                'type' => 'color',
                'group' => 'brand',
                'label' => 'Secondary Color',
                'description' => 'Secondary brand color for accents and highlights',
                'sort_order' => 7,
            ],
            [
                'key' => 'organization_location',
                'value' => 'काठमाडौं, नेपाल',
                'type' => 'text',
                'group' => 'brand',
                'label' => 'Organization Location',
                'description' => 'The location of the organization',
                'sort_order' => 9,
            ],
            [
                'key' => 'organization_establishment',
                'value' => 'स्थापना: २०४६ साल',
                'type' => 'text',
                'group' => 'brand',
                'label' => 'Organization Establishment',
                'description' => 'The establishment date of the organization',
                'sort_order' => 10,
            ],
            
            // Footer Settings
            [
                'key' => 'footer_copyright',
                'value' => 'प्रतिलिपी अधिकार © {{ year }} नेपाल पत्रकार महासंघ। सबै अधिकार सुरक्षित।',
                'type' => 'textarea',
                'group' => 'footer',
                'label' => 'Footer Copyright Text',
                'description' => 'Copyright text displayed in footer. Use {{ year }} for current year.',
                'sort_order' => 1,
            ],
            [
                'key' => 'footer_contact_address',
                'value' => 'मिडिया भिलेज, तिलगंगा काठमाडौं',
                'type' => 'textarea',
                'group' => 'footer',
                'label' => 'Footer Contact Address',
                'description' => 'Address displayed in footer',
                'sort_order' => 3,
            ],
            [
                'key' => 'footer_contact_phone',
                'value' => '+९७७-१-५९१४७८५, ५९१४७२३',
                'type' => 'text',
                'group' => 'footer',
                'label' => 'Footer Contact Phone',
                'description' => 'Phone numbers displayed in footer',
                'sort_order' => 4,
            ],
            [
                'key' => 'footer_contact_email',
                'value' => 'fnjnepalcentral@gmail.com',
                'type' => 'email',
                'group' => 'footer',
                'label' => 'Footer Contact Email',
                'description' => 'Email address displayed in footer',
                'sort_order' => 5,
            ],
            
            // SEO Settings
            [
                'key' => 'default_meta_title',
                'value' => 'नेपाल पत्रकार महासंघ - Federation of Nepali Journalists',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Default Meta Title',
                'description' => 'Default title tag for pages without specific titles',
                'sort_order' => 1,
            ],
            [
                'key' => 'default_meta_description',
                'value' => 'नेपाल पत्रकार महासंघ - नेपालका पत्रकारहरूको राष्ट्रिय संगठन। प्रेस स्वतन्त्रता र पत्रकारिताको व्यावसायिक विकासका लागि कार्यरत।',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Default Meta Description',
                'description' => 'Default meta description for your site (150-160 characters)',
                'sort_order' => 2,
            ],
            
            // Functionality Settings
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'functionality',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode to show maintenance page to visitors',
                'sort_order' => 1,
            ],
            [
                'key' => 'search_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'functionality',
                'label' => 'Enable Search Functionality',
                'description' => 'Enable/disable site-wide search functionality',
                'sort_order' => 3,
            ],
        ];

        foreach ($defaultSettings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}