<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use TJVB\GitHash\Contracts\FinderFactory;
use TJVB\GitHash\Contracts\GitHashRetriever;
use TJVB\LaravelGitHash\Contracts\GitHashLoader;
use TJVB\LaravelGitHash\Contracts\LogContextEnricher;
use TJVB\LaravelGitHash\ViewComponents\GitHash;

class GitHashServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/githash.php',
            'githash'
        );
        $this->app->bind(FinderFactory::class, config('githash.finderFactory'));
        $this->app->bind(GitHashLoader::class, config('githash.hashloader'));
        $this->app->bind(GitHashRetriever::class, config('githash.retriever'));
        $this->app->bind(LogContextEnricher::class, config('githash.logEnricher'));
    }

    public function boot(Repository $config, LogContextEnricher $contextEnricher)
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'githash');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/githash'),
        ]);
        $this->publishes([
            __DIR__ . '/../config/githash.php' => config_path('githash.php'),
        ]);

        Blade::component('githash', GitHash::class);

        if ($config->get('githash.log_context_enabled', true)) {
            $contextEnricher->enrich();
        }
    }
}
