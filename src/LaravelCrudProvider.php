<?php

namespace Shakilnadim\LaravelCrud;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Shakilnadim\LaravelCrud\Console\InstallCommand;

class LaravelCrudProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }

    public function provides(): array
    {
        return [
            InstallCommand::class
        ];
    }
}
