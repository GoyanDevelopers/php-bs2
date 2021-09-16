<?php

namespace Goyan\Bs2;

use Illuminate\Support\ServiceProvider;

class GoyanServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([GoyanGenerateCommand::class]);
        }
    }
}
