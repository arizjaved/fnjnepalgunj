<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\SettingsHelper;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('settings', function () {
            return new SettingsHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share settings with all views
        View::composer('*', function ($view) {
            $view->with([
                'siteName' => SettingsHelper::get('site_name', 'नेपाल पत्रकार महासंघ'),
                'siteNameEnglish' => SettingsHelper::get('site_name_english', 'Federation of Nepali Journalists'),
                'siteTagline' => SettingsHelper::get('site_tagline', 'स्थापना: २०४६ साल'),
                'siteLogo' => SettingsHelper::getLogo(),
                'siteFavicon' => SettingsHelper::getFavicon(),
                'primaryColor' => SettingsHelper::get('primary_color', '#0073b7'),
                'secondaryColor' => SettingsHelper::get('secondary_color', '#004a7f'),
                'isMaintenanceMode' => SettingsHelper::isMaintenanceMode(),
                'isSearchEnabled' => SettingsHelper::isSearchEnabled(),
                'isNewsletterEnabled' => SettingsHelper::isNewsletterEnabled(),
                'isCookieConsentEnabled' => SettingsHelper::isCookieConsentEnabled(),
            ]);
        });

        // Share footer settings with layout views
        View::composer(['layouts.app', 'layouts.admin'], function ($view) {
            $view->with([
                'footerSettings' => SettingsHelper::getFooter(),
                'socialSettings' => SettingsHelper::getSocial(),
                'footerMenuLinks' => SettingsHelper::getFooterMenuLinks(),
                'copyrightText' => SettingsHelper::getCopyrightText(),
            ]);
        });

        // Share SEO settings with all views
        View::composer('*', function ($view) {
            $view->with([
                'defaultMetaTitle' => SettingsHelper::get('default_meta_title', 'नेपाल पत्रकार महासंघ'),
                'defaultMetaDescription' => SettingsHelper::get('default_meta_description', ''),
                'defaultMetaKeywords' => SettingsHelper::get('default_meta_keywords', ''),
                'ogDefaultImage' => SettingsHelper::getOgImage(),
                'googleAnalyticsCode' => SettingsHelper::get('google_analytics_code', ''),
            ]);
        });
    }
}
