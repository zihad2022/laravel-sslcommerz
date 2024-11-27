<?php

namespace Devzihad\LaravelSslcommerz;

use Illuminate\Support\ServiceProvider;

class SslcommerzServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/sslcommerz.php', 'sslcommerz');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/sslcommerz.php' => config_path('sslcommerz.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}
