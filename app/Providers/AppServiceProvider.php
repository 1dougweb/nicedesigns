<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use App\Helpers\SettingsHelper;
use Illuminate\Pagination\Paginator;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register SettingsHelper as singleton
        $this->app->singleton('settings', function () {
            return new SettingsHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Str::macro('readingTime', function ($text) {
            $wordCount = str_word_count(strip_tags($text));
            $readingTime = ceil($wordCount / 200); // 200 words per minute
            return $readingTime;
        });

        Paginator::useBootstrapFive();
        
        // Configure email settings from database
        $this->configureEmailFromDatabase();
    }
    
    /**
     * Configure email settings from database
     */
    private function configureEmailFromDatabase(): void
    {
        try {
            // Only run if database connection is available and tables exist
            if (app()->runningInConsole() && !app()->environment('testing')) {
                // Check if we're in a migration context
                if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                    $this->loadEmailSettings();
                }
            } else {
                // For web requests, always try to load
                $this->loadEmailSettings();
            }
        } catch (\Exception $e) {
            // Silently fail if database is not available (during migrations, etc.)
            // This prevents errors during installation/setup
        }
    }
    
    /**
     * Load email settings from database
     */
    private function loadEmailSettings(): void
    {
        $emailSettings = Setting::where('group', 'email')->get()->keyBy('key');
        
        // Only apply if we have a username configured (indicates SMTP is set up)
        if ($emailSettings->isNotEmpty() && $emailSettings->get('smtp_username')?->value) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $emailSettings->get('smtp_host')->value ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => (int)($emailSettings->get('smtp_port')->value ?? 587),
                'mail.mailers.smtp.username' => $emailSettings->get('smtp_username')->value,
                'mail.mailers.smtp.password' => $emailSettings->get('smtp_password')->value,
                'mail.mailers.smtp.encryption' => $emailSettings->get('smtp_encryption')->value ?? 'tls',
                'mail.from.address' => $emailSettings->get('mail_from_address')->value ?? 'noreply@nicedesigns.com.br',
                'mail.from.name' => $emailSettings->get('mail_from_name')->value ?? 'Nice Designs',
            ]);
        }
    }
}
