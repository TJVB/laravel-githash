<?php
declare(strict_types=1);

return [

    // Option to register custom finders, they need to implement the \TJVB\GitHash\Contracts\GitHashFinder interface
    // if empty it will register the default finders
    'finders' => [

    ],

    'path' => env('GITHASH_REPO_PATH', base_path()),

    'cache_enabled' => env('GITHASH_CACHE_ENABLED', null),

    'cache_file' => storage_path('githash.cache'),

    // If we add the information to the about command
    'about_enabled' => env('GITHASH_ABOUT_ENABLED', true),

    'log_context_enabled' => env('GITHASH_LOG_CONTEXT_ENABLED', true),

    /***
     * Bindings
     */

    // This need to implement the \TJVB\GitHash\Contracts\FinderFactory interface
    'finderFactory' => \TJVB\GitHash\Factories\GitHashFinderFactory::class,

    // This need to implement the TJVB\GitHash\Contracts\GitHashRetriever interface
    'retriever' => \TJVB\GitHash\Retrievers\Retriever::class,

    // This need to implement th \TJVB\LaravelGitHash\Contracts\GitHashLoader interface
    'hashloader' => \TJVB\LaravelGitHash\HashLoader::class,

    // This need to implement th \TJVB\LaravelGitHash\Contracts\LogContextEnricher interface
    'logEnricher' => \TJVB\LaravelGitHash\LogEnricher::class,
];