<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get a setting value with caching
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = "setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            return Setting::get($key, $default);
        });
    }

    /**
     * Set a setting value and clear cache
     */
    public static function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        Setting::set($key, $value, $type, $group);
        
        // Clear specific setting cache
        Cache::forget("setting_{$key}");
        
        // Clear all settings cache if needed
        self::clearCache();
    }

    /**
     * Get all settings grouped by category
     */
    public static function getAll(): array
    {
        return Cache::remember('all_settings', 3600, function () {
            return Setting::all()->groupBy('group')->toArray();
        });
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group): array
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return Setting::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        $keys = [
            'all_settings',
            'settings_group_general',
            'settings_group_contact',
            'settings_group_social',
            'settings_group_seo',
            'settings_group_email',
            'settings_group_appearance',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Clear individual setting caches
        $settings = Setting::pluck('key');
        foreach ($settings as $key) {
            Cache::forget("setting_{$key}");
        }
    }

    /**
     * Get company contact information
     */
    public static function getContactInfo(): array
    {
        return [
            'email' => self::get('contact_email'),
            'phone' => self::get('contact_phone'),
            'whatsapp' => self::get('contact_whatsapp'),
            'address' => self::get('address'),
            'city' => self::get('city'),
            'state' => self::get('state'),
            'zip_code' => self::get('zip_code'),
            'country' => self::get('country'),
        ];
    }

    /**
     * Get social media links
     */
    public static function getSocialMedia(): array
    {
        return [
            'facebook' => self::get('facebook_url'),
            'instagram' => self::get('instagram_url'),
            'twitter' => self::get('twitter_url'),
            'linkedin' => self::get('linkedin_url'),
            'youtube' => self::get('youtube_url'),
            'github' => self::get('github_url'),
            'behance' => self::get('behance_url'),
            'dribbble' => self::get('dribbble_url'),
        ];
    }

    /**
     * Get SEO meta tags
     */
    public static function getSeoTags(): array
    {
        return [
            'title' => self::get('meta_title', self::get('site_name')),
            'description' => self::get('meta_description', self::get('site_description')),
            'keywords' => self::get('site_keywords'),
            'google_analytics' => self::get('google_analytics_id'),
            'facebook_pixel' => self::get('facebook_pixel_id'),
        ];
    }

    /**
     * Get appearance settings
     */
    public static function getAppearance(): array
    {
        return [
            'primary_color' => self::get('primary_color', '#3B82F6'),
            'secondary_color' => self::get('secondary_color', '#1F2937'),
            'accent_color' => self::get('accent_color', '#10B981'),
            'custom_css' => self::get('custom_css'),
            'custom_js' => self::get('custom_js'),
        ];
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode(): bool
    {
        return (bool) self::get('maintenance_mode', false);
    }

    /**
     * Check if user registration is allowed
     */
    public static function isRegistrationAllowed(): bool
    {
        return (bool) self::get('allow_registration', false);
    }

    /**
     * Get pagination settings
     */
    public static function getPaginationSettings(): array
    {
        return [
            'posts_per_page' => (int) self::get('posts_per_page', 12),
            'projects_per_page' => (int) self::get('projects_per_page', 9),
        ];
    }

    /**
     * Get site basic information
     */
    public static function getSiteInfo(): array
    {
        return [
            'name' => self::get('site_name', config('app.name')),
            'description' => self::get('site_description'),
            'logo' => self::get('site_logo'),
            'favicon' => self::get('site_favicon'),
            'timezone' => self::get('timezone', 'America/Sao_Paulo'),
            'date_format' => self::get('date_format', 'd/m/Y'),
            'currency' => self::get('currency', 'BRL'),
        ];
    }
} 