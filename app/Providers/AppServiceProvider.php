<?php

namespace App\Providers;

use App\Console\Commands\BootstrapAdminCommand as RealBootstrapAdminCommand;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('setting', function () {
            return new class {
                public function get(string $key, mixed $default = null): mixed
                {
                    return config('app.settings.' . $key, $default);
                }

                public function set(string $key, mixed $value): void
                {
                    config(['app.settings.' . $key => $value]);
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('admin', EnsureAdmin::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                RealBootstrapAdminCommand::class,
            ]);
        }
    }
}
