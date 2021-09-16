<?php

namespace Goyan\Bs2;

use Illuminate\Support\ServiceProvider;

class Bs2ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([Bs2Command::class]);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/bs2.php' => config_path('bs2.php')], 'config');
        }
    }
}
