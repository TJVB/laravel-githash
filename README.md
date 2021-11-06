# Laravel GitHash
[![pipeline status](https://gitlab.com/tjvb/laravel-githash/badges/master/pipeline.svg)](https://gitlab.com/tjvb/laravel-githash/commits/master)
[![coverage report](https://gitlab.com/tjvb/laravel-githash/badges/master/coverage.svg)](https://gitlab.com/tjvb/laravel-githash/commits/master)

## Purpose
The goal for this is to give a simplified way to get the git hash from your code. This hash can be showed in the admin interface, added to your logs, and used for everything you can imaging.


## Installation
The basic installation is adding this project with composer: `composer require tjvb/laravel-githash`.

### Manual register the service provider.
If you disable the package discovery you need to add `TJVB\LaravelGitHash\GitHashServiceProvider::class,` to the providers array in config/app.php


## Log
The package provides a way to add the githash to add the hash and the short hash to the logs. This is enabled by default.


## Blade component
This package adds a default blade component that you can use with `<x-githash></x-githash>` to show the short and githash on your (admin) pages. This has the option add a version statement short or long to only show on eof the versions. `<x-githash version="short"></x-githash>`  


## Other usages
There ar a lot of options to add the hash to other parts in your application. This can be done with injecting the `\TJVB\LaravelGitHash\Contracts\GitHashLoader`, this provides the `getGitHash` function that returns a `TJVB\GitHash\Values\GitHash` value object that provides the `hash()` and `short()` function.  
```php
use TJVB\LaravelGitHash\Contracts\GitHashLoader;

public function example(GitHashLoader $gitHashLoader)
{
    echo $gitHashLoader->getGitHash()->hash();
} 
```

## Customization and configuration
After publishing the config file with `php artisan vendor:publish` you can change the bindings for the different classes.

### env file variables
In the default configuration there are different ENV variables that can be used.

| Name | Default | Description |
| ---- | ------- | ------- |
| GITHASH_REPO_PATH | base_path()| The path to the git repository, depending on the finder this need to be the root of the repository, or it can be any path in the repository. |
| GITHASH_CACHE_ENABLED | null | If the cache needs to be enabled, if null it will be enabled if debug is disabled. |
| GITHASH_LOG_CONTEXT_ENABLED | true | If the hash needs to be added to the log context. |

### Finders
This package use [`tjvb/githash`](https://gitlab.com/tjvb/githash) to provide the hash. This has different finders available. You can fill a specific finder to use. If you leave it empty it will add the default finders. (With the default factory it means all the finders from that project.)

### Different blade component view
After publishing the blade file `php artisan vendor:publish` you can change the blade. The location after publishing will be `resources/views/vendor/githash/githash.blade.php` here you can edit the blade how you want it.


## Cache
This package uses a file to cache the hash. The cache with a file is used because this should be faster than getting the cache every time it is wanted. (Also depending on the finder and the repository size). It doesn't use the building Laravel cache to prevent the usage of a shared cache. With this file cache it is possible to see that by example one queue runner use another code version than the other runners. This can be helpful in debugging any problems.


## Changelog
We (try to) document all the changes in [CHANGELOG](CHANGELOG.md) so read it for more information.


## Contributing
You are very welcome to contribute, read about it in [CONTRIBUTING](CONTRIBUTING.md)


## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

