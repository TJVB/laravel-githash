<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Tests;

use TJVB\LaravelGitHash\Contracts\GitHashLoader;
use TJVB\LaravelGitHash\HashLoader;

class HashLoaderTest extends TestCase
{

    /**
     * @test
     */
    public function weImplementTheContract(): void
    {
        // setup / mock

        // run
        $hashLoader = $this->app->make(HashLoader::class);

        // verify/assert
        $this->assertInstanceOf(GitHashLoader::class, $hashLoader);
    }

    /**
     * @test
     */
    public function weCanGetTheHash(): void
    {
        $this->markTestIncomplete('todo');
        // setup / mock

        // run

        // verify/assert
    }

    /**
     * @test
     */
    public function weDontUseTheCacheIfDisabled(): void
    {
        $this->markTestIncomplete('todo');
        // setup / mock

        // run

        // verify/assert
    }

    /**
     * @test
     */
    public function weUseTheCacheIfEnabled(): void
    {
        $this->markTestIncomplete('todo');
        // setup / mock

        // run

        // verify/assert
    }

    /**
     * @test
     */
    public function weGetAFreshHashAndSaveTheCacheIfEnabledAndNotYetExist(): void
    {
        $this->markTestIncomplete('todo');
        // setup / mock

        // run

        // verify/assert
    }
}
