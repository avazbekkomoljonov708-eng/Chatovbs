<?php

namespace App\Providers;

use App\Support\UserSettings;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $locale = session('app_locale', config('app.locale'));

        if (auth()->check()) {
            $settings = UserSettings::for(auth()->user());
            $userLocale = $settings['language'] ?? $locale;

            if (in_array($userLocale, ['uz', 'ko', 'ru', 'en'], true)) {
                $locale = $userLocale;
            }
        }

        if (in_array($locale, ['uz', 'ko', 'ru', 'en'], true)) {
            session()->put('app_locale', $locale);
            app()->setLocale($locale);
        }
    }
}
