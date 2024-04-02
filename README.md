# Laravel GitHash

[![Latest Stable Version](https://poser.pugx.org/tjvb/laravel-githash/v)](https://packagist.org/packages/tjvb/laravel-githash)
[![Pipeline status](https://gitlab.com/tjvb/laravel-githash/badges/master/pipeline.svg)](https://gitlab.com/tjvb/laravel-githash/-/pipelines?page=1&scope=all&ref=master)
[![Coverage report](https://gitlab.com/tjvb/laravel-githash/badges/master/coverage.svg)](https://gitlab.com/tjvb/laravel-githash/-/pipelines?page=1&scope=all&ref=master)
[![Tested on PHP 8.0 to 8.3](https://img.shields.io/badge/Tested%20on-PHP%208.0%20|%208.1%20|%208.2%20|%208.3-brightgreen.svg?maxAge=2419200)](https://gitlab.com/tjvb/laravel-githash/-/pipelines?page=1&scope=all&ref=master)
[![Tested on Laravel 8 to 11](https://img.shields.io/badge/Tested%20on-Laravel%208%20|%209%20|%2010%20|%2011-brightgreen.svg?maxAge=2419200)](https://gitlab.com/tjvb/laravel-mail-catchall/-/pipelines?page=1&scope=all&ref=master)
[![Latest Unstable Version](https://poser.pugx.org/tjvb/laravel-githash/v/unstable)](https://packagist.org/packages/tjvb/laravel-githash)


[![PHP Version Require](https://poser.pugx.org/tjvb/laravel-githash/require/php)](https://packagist.org/packages/tjvb/laravel-githash)
[![Laravel Version Require](https://poser.pugx.org/tjvb/laravel-githash/require/laravel/framework)](https://packagist.org/packages/tjvb/laravel-mail-catchall)
[![PHPMD](https://img.shields.io/badge/PHPMD-checked-brightgreen.svg)](https://gitlab.com/tjvb/laravel-githash/-/blob/master/phpmd.xml.dist)
[![PHPStan](https://img.shields.io/badge/PHPStan-checked-brightgreen.svg)](https://gitlab.com/tjvb/laravel-githash/-/blob/master/phpstan.neon.dist)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg)](https://gitlab.com/tjvb/laravel-githash/-/blob/master/phpcs.xml.dist)


[![License](https://poser.pugx.org/tjvb/laravel-githash/license)](https://packagist.org/packages/tjvb/laravel-githash)


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

## About command
If the Laravel about command is available it will add information about the hash and the cache status. This can be disabled in the config.

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
**It is important to have the cache file pointed to a place that isn't shared between your deployments.**

### env file variables
In the default configuration there are different ENV variables that can be used.

| Name | Default | Description                                                                                                                                  |
| ---- | ------- |----------------------------------------------------------------------------------------------------------------------------------------------|
| GITHASH_REPO_PATH | base_path()| The path to the git repository, depending on the finder this need to be the root of the repository, or it can be any path in the repository. |
| GITHASH_CACHE_ENABLED | null | If the cache needs to be enabled, if null it will be enabled if debug is disabled.                                                           |
| GITHASH_ABOUT_ENABLED | true | If information about the hash and the cache status needs to be added to the Laravel About command.                                           |
| GITHASH_LOG_CONTEXT_ENABLED | true | If the hash needs to be added to the log context.                                                                                            |

### Finders
This package use [`tjvb/githash`](https://gitlab.com/tjvb/githash) to provide the hash. This has different finders available. You can fill a specific finder to use. If you leave it empty it will add the default finders. (With the default factory it means all the finders from that project.)

### Different blade component view
After publishing the blade file `php artisan vendor:publish` you can change the blade. The location after publishing will be `resources/views/vendor/githash/githash.blade.php` here you can edit the blade how you want it.

### Custom implementations
It is possible to overwrite the different classes, this can be done by implementing the interfaces and update the config file. The config file contains the implementations and has a comment to point to the correct interface to implement.


## Cache
This package uses a file to cache the hash. The cache with a file is used because this should be faster than getting the cache every time it is wanted. (Also depending on the finder and the repository size). It doesn't use the building Laravel cache to prevent the usage of a shared cache. With this file cache it is possible to see that by example one queue runner use another code version than the other runners. This can be helpful in debugging any problems.

## Usage without git on your server
Depending on the way you deploy your application it is possible that you don't have the repository information available. For this it will also be usefull to write the hash to the cache file.

### Envoyer example
If you use [Envoyer](https://envoyer.io/) you don't have the git repository on your server. And the full storage dir will be shared between your deployments. That needs some customization.  
First update your configuration to have a cache file outside the shared directory.  
```php
// in config/githash.php
    'cache_file' => base_path('githash.cache'),
```
Then add a new deployment hook that will be executed before you install your composer dependencies to place the hash in the cache file:
```shell
cd {{release}}

echo {{sha}} > githash.cache
```
With this changes you will have the cachefile without the need to have the repository on the server and can use the hash on the wanted locations.

## Changelog
We (try to) document all the changes in [CHANGELOG](CHANGELOG.md) so read it for more information.


## Contributing
You are very welcome to contribute, read about it in [CONTRIBUTING](CONTRIBUTING.md)


## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

