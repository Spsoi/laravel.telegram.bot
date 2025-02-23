<?php

namespace App\Modules\TelegramBot\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\TelegramBot\Domain\TelegramApiClientInterface;
use App\Modules\TelegramBot\Infrastructure\TelegramApiClient;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(TelegramApiClientInterface::class, TelegramApiClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }
}
