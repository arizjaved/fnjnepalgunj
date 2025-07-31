<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteSetting;

class SeedSiteSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed default site settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding site settings...');

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
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'brand',
                'label' => 'Site Logo',
                'description' => 'Upload your site logo (recommended: 200x80px)',
                'sort_order' => 4,
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'brand',
                'label' => 'Site Favicon',
                'description' => 'Upload your site favicon (16x16 or 32x32 pixels)',
                'sort_order' => 5,
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
                'key' => 'font_family',
                'value' => 'Inter, system-ui, sans-serif',
                'type' => 'select',
                'group' => 'brand',
                'label' => 'Font Family',
                'description' => 'Primary font family for the website',
                'sort_order' => 8,
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
                'key' => 'footer_menu_links',
                'value' => json_encode([
                    ['name' => 'गोपनीयता नीति', 'url' => '/privacy-policy'],
                    ['name' => 'सेवाका सर्तहरू', 'url' => '/terms-of-service'],
                    ['name' => 'सम्पर्क', 'url' => '/contact'],
                ]),
                'type' => 'json',
                'group' => 'footer',
                'label' => 'Footer Menu Links',
                'description' => 'Links displayed in footer menu',
                'sort_order' => 2,
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
            [
                'key' => 'footer_newsletter_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'footer',
                'label' => 'Enable Newsletter Signup',
                'description' => 'Show newsletter signup form in footer',
                'sort_order' => 6,
            ],
            [
                'key' => 'footer_newsletter_title',
                'value' => 'समाचार सदस्यता',
                'type' => 'text',
                'group' => 'footer',
                'label' => 'Newsletter Section Title',
                'description' => 'Title for newsletter signup section',
                'sort_order' => 7,
            ],
            [
                'key' => 'footer_newsletter_description',
                'value' => 'नवीनतम समाचार र अपडेटहरू प्राप्त गर्न सदस्यता लिनुहोस्',
                'type' => 'textarea',
                'group' => 'footer',
                'label' => 'Newsletter Description',
                'description' => 'Description text for newsletter signup',
                'sort_order' => 8,
            ],
            [
                'key' => 'footer_additional_text',
                'value' => '',
                'type' => 'textarea',
                'group' => 'footer',
                'label' => 'Additional Footer Text',
                'description' => 'Additional text or disclaimers for footer',
                'sort_order' => 9,
            ],

            // Social Media Settings
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Your Facebook page URL',
                'sort_order' => 1,
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Your Twitter profile URL',
                'sort_order' => 2,
            ],
            [
                'key' => 'youtube_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube URL',
                'description' => 'Your YouTube channel URL',
                'sort_order' => 3,
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Your Instagram profile URL',
                'sort_order' => 4,
            ],
            [
                'key' => 'linkedin_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'Your LinkedIn profile URL',
                'sort_order' => 5,
            ],
            [
                'key' => 'facebook_embed',
                'value' => '',
                'type' => 'textarea',
                'group' => 'social',
                'label' => 'Facebook Embed Code',
                'description' => 'Facebook page embed code',
                'sort_order' => 6,
            ],
            [
                'key' => 'twitter_embed',
                'value' => '',
                'type' => 'textarea',
                'group' => 'social',
                'label' => 'Twitter Embed Code',
                'description' => 'Twitter timeline embed code',
                'sort_order' => 7,
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
            [
                'key' => 'default_meta_keywords',
                'value' => 'नेपाल पत्रकार महासंघ, FNJ, journalism, Nepal, media, press freedom, journalists',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Default Meta Keywords',
                'description' => 'Default meta keywords for your site (comma separated)',
                'sort_order' => 3,
            ],
            [
                'key' => 'google_analytics_code',
                'value' => '',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Google Analytics Tracking Code',
                'description' => 'Google Analytics 4 (GA4) tracking code or Google Tag Manager code',
                'sort_order' => 4,
            ],
            [
                'key' => 'google_search_console',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Google Search Console Verification',
                'description' => 'Google Search Console verification meta tag content',
                'sort_order' => 5,
            ],
            [
                'key' => 'og_default_image',
                'value' => null,
                'type' => 'image',
                'group' => 'seo',
                'label' => 'Default Open Graph Image',
                'description' => 'Default image for social media sharing (1200x630px recommended)',
                'sort_order' => 6,
            ],
            [
                'key' => 'robots_txt',
                'value' => "User-agent: *\nDisallow: /admin\nDisallow: /api\nSitemap: {{ url }}/sitemap.xml",
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Robots.txt Content',
                'description' => 'Content for robots.txt file. Use {{ url }} for site URL.',
                'sort_order' => 7,
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
                'key' => 'maintenance_message',
                'value' => 'हाम्रो वेबसाइट अहिले मर्मत कार्यमा छ। कृपया केही समयपछि फेरि प्रयास गर्नुहोस्।',
                'type' => 'textarea',
                'group' => 'functionality',
                'label' => 'Maintenance Mode Message',
                'description' => 'Message to display when site is in maintenance mode',
                'sort_order' => 2,
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
            [
                'key' => 'newsletter_signup_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'functionality',
                'label' => 'Enable Newsletter Signup',
                'description' => 'Enable newsletter subscription functionality',
                'sort_order' => 4,
            ],
            [
                'key' => 'cookie_consent_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'functionality',
                'label' => 'Enable Cookie Consent Banner',
                'description' => 'Show cookie consent banner for GDPR compliance',
                'sort_order' => 5,
            ],
            [
                'key' => 'cookie_consent_message',
                'value' => 'यो वेबसाइटले तपाईंको अनुभव सुधार गर्न कुकीहरू प्रयोग गर्छ। साइट प्रयोग गरेर तपाईं कुकी नीतिमा सहमत हुनुहुन्छ।',
                'type' => 'textarea',
                'group' => 'functionality',
                'label' => 'Cookie Consent Message',
                'description' => 'Message displayed in cookie consent banner',
                'sort_order' => 6,
            ],
            [
                'key' => 'site_caching_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'functionality',
                'label' => 'Enable Site Caching',
                'description' => 'Enable caching for better performance',
                'sort_order' => 7,
            ],
            [
                'key' => 'comments_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'functionality',
                'label' => 'Enable Comments',
                'description' => 'Allow comments on news articles and posts',
                'sort_order' => 8,
            ],
            [
                'key' => 'user_registration_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'functionality',
                'label' => 'Enable User Registration',
                'description' => 'Allow new users to register on the site',
                'sort_order' => 9,
            ],

            // Chairman's Message Settings
            [
                'key' => 'chairman_name',
                'value' => 'श्री बिपुल पोखरेल',
                'type' => 'text',
                'group' => 'chairman',
                'label' => 'Chairman Name',
                'description' => 'Name of the current chairman',
                'sort_order' => 1,
            ],
            [
                'key' => 'chairman_position',
                'value' => 'अध्यक्ष',
                'type' => 'text',
                'group' => 'chairman',
                'label' => 'Chairman Position',
                'description' => 'Position/title of the chairman',
                'sort_order' => 2,
            ],
            [
                'key' => 'chairman_photo',
                'value' => null,
                'type' => 'image',
                'group' => 'chairman',
                'label' => 'Chairman Photo',
                'description' => 'Upload chairman photo (recommended: 300x400px)',
                'sort_order' => 3,
            ],
            [
                'key' => 'chairman_message',
                'value' => 'नेपाल पत्रकार महासंघको तर्फबाट सबै पत्रकार साथीहरूलाई हार्दिक स्वागत छ। हामी प्रेस स्वतन्त्रता र पत्रकारिताको व्यावसायिक विकासका लागि निरन्तर कार्यरत छौं।',
                'type' => 'textarea',
                'group' => 'chairman',
                'label' => 'Chairman Message',
                'description' => 'Message from the chairman to be displayed on homepage',
                'sort_order' => 4,
            ],
            [
                'key' => 'chairman_message_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'chairman',
                'label' => 'Enable Chairman Message',
                'description' => 'Show chairman message section on homepage',
                'sort_order' => 5,
            ],
        ];

        $count = 0;
        foreach ($defaultSettings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
            $count++;
        }

        $this->info("Successfully seeded {$count} site settings!");
        return 0;
    }
}
