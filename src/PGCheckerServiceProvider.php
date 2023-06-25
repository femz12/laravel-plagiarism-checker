<?php

namespace DavidO\PGChecker;

use Illuminate\Support\ServiceProvider;

class PGCheckerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/copyleaks.php' => config_path('copyleaks.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'pg-checker');

    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/copyleaks.php', 'copyleaks'
        );

        $this->app->singleton(PGChecker::class, function () {
            return new PGChecker();
        });

        $this->app->alias(PGChecker::class, 'pg-checker');
    }
}
