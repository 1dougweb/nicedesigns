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

if (! function_exists('footer_info')) {
    /**
     * Get footer information
     */
    function footer_info(?string $key = null): mixed
    {
        $footerInfo = SettingsHelper::getFooterInfo();
        
        if ($key === null) {
            return $footerInfo;
        }
        
        return $footerInfo[$key] ?? null;
    }
}

if (! function_exists('format_date')) {
    /**
     * Format date using system configuration
     */
    function format_date($date, ?string $format = null): string
    {
        if (!$date) {
            return '';
        }
        
        // Convert to Carbon instance if needed
        if (!$date instanceof \Carbon\Carbon) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        // Use custom format or system default
        $format = $format ?? site_setting('date_format') ?? 'd/m/Y';
        
        return $date->format($format);
    }
}

if (! function_exists('format_datetime')) {
    /**
     * Format datetime using system configuration
     */
    function format_datetime($date, ?string $format = null): string
    {
        if (!$date) {
            return '';
        }
        
        // Convert to Carbon instance if needed
        if (!$date instanceof \Carbon\Carbon) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        // Use custom format or system default with time
        $dateFormat = site_setting('date_format') ?? 'd/m/Y';
        $format = $format ?? "$dateFormat H:i";
        
        return $date->format($format);
    }
}

if (! function_exists('format_currency')) {
    /**
     * Format currency using system configuration
     */
    function format_currency($value, ?string $currency = null): string
    {
        if (!is_numeric($value)) {
            return '';
        }
        
        $currency = $currency ?? site_setting('currency') ?? 'BRL';
        
        switch ($currency) {
            case 'BRL':
                return 'R$ ' . number_format($value, 2, ',', '.');
            case 'USD':
                return '$' . number_format($value, 2, '.', ',');
            case 'EUR':
                return '€' . number_format($value, 2, ',', '.');
            default:
                return $currency . ' ' . number_format($value, 2, '.', ',');
        }
    }
} 