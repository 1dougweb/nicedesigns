<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
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
    }
}
