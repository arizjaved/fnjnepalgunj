<?php

namespace App\Helpers;

use App\Models\SiteSetting;

class SettingsHelper
{
    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }

    /**
     * Get all settings by group
     */
    public static function getGroup($group)
    {
        return SiteSetting::getByGroup($group);
    }

    /**
     * Get brand settings
     */
    public static function getBrand()
    {
        return self::getGroup('brand');
    }

    /**
     * Get footer settings
     */
    public static function getFooter()
    {
        return self::getGroup('footer');
    }

    /**
     * Get SEO settings
     */
    public static function getSeo()
    {
        return self::getGroup('seo');
    }

    /**
     * Get social media settings
     */
    public static function getSocial()
    {
        return self::getGroup('social');
    }

    /**
     * Get functionality settings
     */
    public static function getFunctionality()
    {
        return self::getGroup('functionality');
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode()
    {
        return self::get('maintenance_mode', '0') === '1';
    }

    /**
     * Check if search is enabled
     */
    public static function isSearchEnabled()
    {
        return self::get('search_enabled', '1') === '1';
    }

    /**
     * Check if newsletter signup is enabled
     */
    public static function isNewsletterEnabled()
    {
        return self::get('newsletter_signup_enabled', '1') === '1';
    }

    /**
     * Check if cookie consent is enabled
     */
    public static function isCookieConsentEnabled()
    {
        return self::get('cookie_consent_enabled', '1') === '1';
    }

    /**
     * Check if caching is enabled
     */
    public static function isCachingEnabled()
    {
        return self::get('site_caching_enabled', '1') === '1';
    }

    /**
     * Get site logo URL
     */
    public static function getLogo()
    {
        $logo = self::get('site_logo');
        return $logo ? asset('storage/' . $logo) : null;
    }

    /**
     * Get site favicon URL
     */
    public static function getFavicon()
    {
        $favicon = self::get('site_favicon');
        return $favicon ? asset('storage/' . $favicon) : null;
    }

    /**
     * Get Open Graph default image URL
     */
    public static function getOgImage()
    {
        $ogImage = self::get('og_default_image');
        return $ogImage ? asset('storage/' . $ogImage) : null;
    }

    /**
     * Get footer menu links
     */
    public static function getFooterMenuLinks()
    {
        $links = self::get('footer_menu_links', '[]');
        return is_string($links) ? json_decode($links, true) : $links;
    }

    /**
     * Get processed copyright text with year replacement
     */
    public static function getCopyrightText()
    {
        $copyright = self::get('footer_copyright', '');
        return str_replace('{{ year }}', date('Y'), $copyright);
    }

    /**
     * Get robots.txt content with URL replacement
     */
    public static function getRobotsTxt()
    {
        $robots = self::get('robots_txt', '');
        return str_replace('{{ url }}', url('/'), $robots);
    }
}
