<?php

namespace TidianeHamed\LaravelApiStarter;

use Illuminate\Support\ServiceProvider;
use TidianeHamed\LaravelApiStarter\Commands\ApiStarterCommand;

class ApiStarterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // Register commands if running in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                ApiStarterCommand::class,
            ]);
        }

        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/api-starter.php' => config_path('api-starter.php'),
        ], 'api-starter-config');

        // Publish stub files
        $this->publishes([
            __DIR__.'/../stubs' => resource_path('stubs/api-starter'),
        ], 'api-starter-stubs');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/api-starter.php',
            'api-starter'
        );

        // Register services
        $this->app->singleton('api-starter', function ($app) {
            return new ApiStarterService($app);
        });
    }
}