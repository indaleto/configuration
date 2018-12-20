<?php

namespace indaleto\configuration;

use Illuminate\Support\ServiceProvider;

class ConfigurationProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('indaleto\configuration\configurationController');
        $this->loadViewsFrom(__DIR__.'/views', 'adminConfiguration');
    }

}
