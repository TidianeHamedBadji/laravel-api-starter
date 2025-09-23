<?php

namespace TidianeHamed\LaravelApiStarter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TidianeHamed\LaravelApiStarter\ApiStarterServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ApiStarterServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        // Setup the application configuration for testing
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}