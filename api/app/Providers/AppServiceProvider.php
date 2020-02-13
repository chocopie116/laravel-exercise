<?php

namespace App\Providers;

use App\Services\ArticleService;
use GuzzleHttp\Client;
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
        $this->app->bind(ArticleService::class, function ($app) {
            return new ArticleService($app->get(Client::class));
        });

        $this->app->bind(Client::class, function () {
            return new Client();
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
