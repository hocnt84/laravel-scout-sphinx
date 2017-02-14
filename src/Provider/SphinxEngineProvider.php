<?php
namespace Hocnt\LaravelScoutSphinx\Provider;

use Hocnt\LaravelScoutSphinx\Engine\SphinxEngine;
use Illuminate\Support\ServiceProvider as Provider;
use Laravel\Scout\EngineManager;

class SphinxEngineProvider extends Provider
{
    public function boot()
    {
        resolve(EngineManager::class)->extend('sphinxsearch', function ($app) {
            return new SphinxEngine(config('scout.sphinx'));
        });
    }

    public function register()
    {
        $this->app->singleton(EngineManager::class, function ($app) {
            return new EngineManager($app);
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/scout.php' => config_path('scout.php'),
            ]);
        }
    }
}
