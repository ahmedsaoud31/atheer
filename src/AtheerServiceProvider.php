<?php

namespace Atheer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Atheer\Console\Commands\AtheerCommand;
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
        $this->publishes([
            __DIR__.'/../config/atheer.php' => config_path('atheer.php'),
            __DIR__.'/../app/Http/Controllers/AtheerController.php' => app_path('Http/Controllers/AtheerController.php'),
            __DIR__.'/../resources/views/atheer' => resource_path('views/vendor/atheer'),
            __DIR__.'/../lang' => base_path('lang'),
            __DIR__.'/../public/themes/tabler' => public_path('/themes/tabler'),
            __DIR__.'/../routes' => base_path('/routes'),
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                AtheerCommand::class,
            ]);
        }
        $this->loadViewsFrom(__DIR__.'/../resources/views/atheer', 'atheer');
        $this->loadRoutes();
        $this->cacheSettings();

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
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
            copy(__DIR__.'/../routes/atheer.php', base_path('/routes/atheer.php'));
        }
        $this->loadRoutesFrom(base_path('routes/atheer.php'));
    }
}