<?php

namespace Atheer;

use Cache;
use Atheer\Facades\Atheer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Atheer\Console\Commands\MakeCommand;
use Atheer\Console\Commands\FreshCommand;
use Atheer\Console\Commands\AtheerCommand;
use Atheer\Console\Commands\DeleteCommand;

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

            // Publish atheer config
            __DIR__.'/../config/atheer.php' => config_path('atheer.php'),

            // Publish atheer Files
            __DIR__.'/../app/Atheer' => app_path('Atheer'),

            // Publish atheer Controllers
            __DIR__.'/../app/Http/Controllers/Atheer' => app_path('Http/Controllers/Atheer'),

            // Publish atheer Requests
            __DIR__.'/../app/Http/Requests/Atheer' => app_path('Http/Requests/Atheer'),

            // Publish atheer Mails
            __DIR__.'/../app/Mail' => app_path('Mail'),

            // Publish atheer Policies
            __DIR__.'/../app/Policies' => app_path('Policies'),

            // Publish atheer Repositories
            __DIR__.'/../app/Repositories/UserRepository.php' => app_path('Repositories/UserRepository.php'),
            __DIR__.'/../app/Repositories/Atheer' => app_path('Repositories/Atheer'),

            // Publish atheer views
            __DIR__.'/../resources/views/vendor/atheer' => resource_path('views/vendor/atheer'),

            // Publish atheer lang
            __DIR__.'/../lang' => base_path('lang'),

            // Publish atheer public files
            __DIR__.'/../public/atheer_public' => public_path('/atheer_public'),

            // Publish atheer routes
            __DIR__.'/../routes' => base_path('routes'),
            
            // Publish atheer Seeders
            __DIR__.'/../database/seeders' => base_path('database/seeders'),
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                AtheerCommand::class,
                MakeCommand::class,
                DeleteCommand::class,
                FreshCommand::class,
            ]);
        }
        $this->loadViewsFrom(__DIR__.'/../resources/views/vendor/atheer', 'atheer');
        $this->loadRoutes();
        $this->cacheSettings();

        $loader = AliasLoader::getInstance();
        $loader->alias('Atheer', 'Atheer\Facades\Atheer');
        $loader->alias('Ath', 'Atheer\Facades\Ath');

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
        if(Schema::hasTable('locale')){
            if($locale = Cache::get('locale')){
                if(in_array($locale, Atheer::languageCodes())){
                    Config::set('app.locale', $locale);
                }
            } 
        }
    }

    private function loadRoutes()
    {
        if(!file_exists(base_path('/routes/atheer.php'))){
            copy(__DIR__.'/../routes/atheer.php', base_path('/routes/atheer.php'));
        }
        $this->loadRoutesFrom(Atheer::getBaseRoute()."/atheer.php");
    }
}