<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
        $this->registerAliases();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! app()->isLocal()) {
            URL::forceScheme('https');
        }

        Carbon::setLocale(config('app.locale'));
    }

    private function registerAliases(): void
    {
        $this->app->alias(
            \App\Models\Role::class,
            \Spatie\Permission\Models\Role::class
        );

        $this->app->alias(
            \App\Models\Permission::class,
            \Spatie\Permission\Models\Permission::class
        );
    }
}
