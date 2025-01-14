<?php

namespace LithiumDev\Tests;

use LithiumDev\Impersonate\ImpersonateServiceProvider;
use LithiumDev\Tests\Stubs\Models\User;
use LithiumDev\Tests\Stubs\Models\OtherUser;
use Orchestra\Database\ConsoleServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @param void
     * @return  void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench']);

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->setUpRoutes();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Setup the right User class (using stub)
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('auth.providers.admins', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);
        $app['config']->set('auth.guards.admin', [
            'driver' => 'session',
            'provider' => 'admins',
        ]);

        // Setup a guard from another user table/model
        $app['config']->set('auth.providers.otherusers', [
            'driver' => 'eloquent',
            'model' => OtherUser::class,
        ]);
        $app['config']->set('auth.guards.otheruser', [
            'driver' => 'session',
            'provider' => 'otherusers',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            ImpersonateServiceProvider::class,
        ];
    }

    /**
     * @return void
     */
    protected function setUpRoutes()
    {
        // Add routes by calling macro
        $this->app['router']->impersonate();

        // Refresh named routes
        $this->app['router']->getRoutes()->refreshNameLookups();
    }
}
