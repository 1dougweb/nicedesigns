<?php

use App\Helpers\SettingsHelper;

if (! function_exists('setting')) {
    /**
     * Get a setting value
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return SettingsHelper::get($key, $default);
    }
}

if (! function_exists('site_setting')) {
    /**
     * Get site basic information
     */
    function site_setting(?string $key = null): mixed
    {
        $siteInfo = SettingsHelper::getSiteInfo();
        
        if ($key === null) {
            return $siteInfo;
        }
        
        return $siteInfo[$key] ?? null;
    }
}

if (! function_exists('contact_info')) {
    /**
     * Get contact information
     */
    function contact_info(?string $key = null): mixed
    {
        $contactInfo = SettingsHelper::getContactInfo();
        
        if ($key === null) {
            return $contactInfo;
        }
        
        return $contactInfo[$key] ?? null;
    }
}

if (! function_exists('social_media')) {
    /**
     * Get social media links
     */
    function social_media(?string $key = null): mixed
    {
        $socialMedia = SettingsHelper::getSocialMedia();
        
        if ($key === null) {
            return $socialMedia;
        }
        
        return $socialMedia[$key] ?? null;
    }
}

if (! function_exists('seo_tags')) {
    /**
     * Get SEO meta tags
     */
    function seo_tags(?string $key = null): mixed
    {
        $seoTags = SettingsHelper::getSeoTags();
        
        if ($key === null) {
            return $seoTags;
        }
        
        return $seoTags[$key] ?? null;
    }
}

if (! function_exists('appearance')) {
    /**
     * Get appearance settings
     */
    function appearance(?string $key = null): mixed
    {
        $appearance = SettingsHelper::getAppearance();
        
        if ($key === null) {
            return $appearance;
        }
        
        return $appearance[$key] ?? null;
    }
} 