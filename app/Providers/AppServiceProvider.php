<?php

namespace App\Providers;

use App\Services\Telegram\Telegram;
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
        app()->bind(Telegram::class, function() {
            $bot = config('telegram.bot');

            return new Telegram($bot['api-key'], $bot['name']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
