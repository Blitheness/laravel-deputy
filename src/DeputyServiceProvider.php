<?php

namespace Blitheness\Deputy;

use Illuminate\Support\ServiceProvider;
use Blitheness\Deputy\Facades\Deputy;

class DeputyServiceProvider extends ServiceProvider {
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            __DIR__.'/../config/deputy.php' => config_path('deputy.php')
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('deputy', function() {
            return Deputy::getInstance();
        });
    }
}
