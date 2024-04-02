<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Tests;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\WithFaker;
use TJVB\LaravelGitHash\Contracts\GitHashLoader;
use TJVB\LaravelGitHash\HashLoader;
use TJVB\LaravelGitHash\Tests\Fixtures\FakeGitHashRetriever;

final class HashLoaderTest extends TestCase
{
    use WithFaker;

    public const FIXED_CACHE_PATH = __DIR__ . '/Fixtures/testhash.cache';

    // This is the hash that is written in the file above
    public const FIXED_HASH = '03c2d7726c53935e308a8bc29ee0f85d540c7190';

    public const TEMP_PATH = __DIR__ . '/tmp/';

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
    public function weDontUseTheCacheIfDisabled(): void
    {
        // setup / mock
        $hash = $this->faker->sha1;

        $config = new Repository();
        $config->set('githash.cache_enabled', false);
        $config->set('githash.cache_file', self::FIXED_CACHE_PATH);

        $retriever = new FakeGitHashRetriever();
        $retriever->hash = $hash;

        $hashLoader = $this->app->make(HashLoader::class, [
            'config' => $config,
            'retriever' => $retriever,
        ]);

        // run

        $result = $hashLoader->getGithash();

        // verify/assert
        $this->assertEquals($hash, $result->hash());
    }

    /**
     * @test
     */
    public function weUseTheCacheIfEnabled(): void
    {
        // setup / mock
        $hash = $this->faker->sha1;

        $config = new Repository();
        $config->set('githash.cache_enabled', true);
        $config->set('githash.cache_file', self::FIXED_CACHE_PATH);

        $retriever = new FakeGitHashRetriever();
        $retriever->hash = $hash;

        $hashLoader = $this->app->make(HashLoader::class, [
            'config' => $config,
            'retriever' => $retriever,
        ]);

        // run

        $result = $hashLoader->getGithash();

        // verify/assert
        $this->assertEquals(self::FIXED_HASH, $result->hash());
    }

    /**
     * @test
     */
    public function weGetAFreshHashAndSaveTheCacheIfEnabledAndNotYetExist(): void
    {
        // setup / mock
        $hash = $this->faker->sha1;

        $cacheFile = self::TEMP_PATH . $this->faker->md5 . '.cache';
        // be sure it doesn't exist
        @unlink($cacheFile);

        $config = new Repository();
        $config->set('githash.cache_enabled', true);
        $config->set('githash.cache_file', $cacheFile);

        $retriever = new FakeGitHashRetriever();
        $retriever->hash = $hash;

        $hashLoader = $this->app->make(HashLoader::class, [
            'config' => $config,
            'retriever' => $retriever,
        ]);

        $result = $hashLoader->getGithash();

        // verify/assert
        $this->assertEquals($hash, $result->hash());
        $this->assertFileExists($cacheFile);
        $this->assertEquals($hash, file_get_contents($cacheFile));
        @unlink($cacheFile);
    }
}
