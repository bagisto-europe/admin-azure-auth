<?php

namespace Bagisto\AzureAuth\Providers;

use Bagisto\AzureAuth\Console\Commands\ConfigureAzure;
use Bagisto\AzureAuth\Providers\EventServiceProvider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class AzureAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/services.php',
            'services'
        );

        $this->commands([
            ConfigureAzure::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
                
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'azure-auth');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'azure-auth');

        $this->publishes([
            __DIR__.'/../Resources/img' => public_path('vendor/azure-auth'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../Resources/views/users' => resource_path('admin-themes/default/views'),
        ], 'azure-auth');
    }
}
