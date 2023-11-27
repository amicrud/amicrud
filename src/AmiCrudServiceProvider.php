<?php

namespace AmiCrud;

use AmiCrud\Commands\AmiCrudCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class AmiCrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes, views, etc.
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'amicrud');

        // Blade::directive('amicrudScripts', function () {
        //     $scripts = View::make('amicrud::amicrud.shared.scripts-directive')->render();
        //     return $scripts;
        // });

        // Blade::directive('amicrudStyles', function () {
        //     $scripts = View::make('amicrud::amicrud.shared.styles-directive')->render(); 
        //     return $scripts;
        // });

        // For example, to publish views:
        // $this->publishes([
        //     __DIR__.'/path/to/views' => resource_path('views/vendor/amicrud'),
        // ]);
        
        // Register routes if any
        // include __DIR__.'/routes.php';

        $this->publishes([
            __DIR__.'/../config/amicrud.php' => config_path('amicrud.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register any bindings or dependencies for your package.
        
        $this->app->singleton('amicrud', function ($app) {
            return new AmiCrud();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                AmiCrudCommand::class,
            ]);
        }

    }
}
