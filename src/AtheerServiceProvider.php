<?php

namespace Atheer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Pagination\Paginator;
use Atheer\Console\Commands\AtheerCommand;
use Atheer\Console\Commands\MakeCommand;
use Atheer\Console\Commands\DeleteCommand;
use Cache;

class AtheerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        
        Blade::componentNamespace('App\\Atheer\\View\\Components', 'atheer-components');

        $this->publishes([
            /*__DIR__.'/../config/atheer.php' => config_path('atheer.php'),
            __DIR__.'/../app/Http/Controllers/AtheerController.php' => app_path('Http/Controllers/AtheerController.php'),
            __DIR__.'/../resources/views/vendor/atheer' => resource_path('views/vendor/atheer'),
            __DIR__.'/../lang' => base_path('lang'),
            __DIR__.'/../public/themes/tabler' => public_path('/themes/tabler'),
            __DIR__.'/../routes' => base_path('/routes'),*/
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                AtheerCommand::class,
                MakeCommand::class,
                DeleteCommand::class,
            ]);
        }
        $this->loadViewsFrom(__DIR__.'/../resources/views/vendor/atheer', 'atheer');
        $this->loadRoutes();
        $this->cacheSettings();

        // Bind breadcrumbs package
        /*$this->app->register(
            'DaveJamesMiller\Breadcrumbs\ServiceProvider'
        );*/

        $loader = AliasLoader::getInstance();
        $loader->alias('Atheer', 'Atheer\Facades\Atheer');

        Paginator::defaultView('atheer::pagination.default');
        Paginator::defaultSimpleView('atheer::pagination.simple-default');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->aliasMiddleware('atheer-auth', \Atheer\Middleware\Authenticate::class);
    }

    private function cacheSettings()
    {
        if($layout = Cache::get('atheer_layout')){
            if(in_array($layout, config('atheer.layouts'))){
                Config::set('atheer.layout', $layout);
            }
        }

        if($locale = Cache::get('locale')){
            if(in_array($locale, ['ar', 'en'])){
                Config::set('app.locale', $locale);
            }
        } 
    }

    private function loadRoutes()
    {
        if(!file_exists(base_path('/routes/atheer.php'))){
            //copy(__DIR__.'/../routes/atheer.php', base_path('/routes/atheer.php'));
        }
        $this->loadRoutesFrom(__DIR__.'/../routes/atheer.php');
    }
}