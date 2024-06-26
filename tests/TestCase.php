<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use TJVB\LaravelGitHash\GitHashServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Get the custom Service Provider
     *
     * @param Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            GitHashServiceProvider::class,
        ];
    }
}
