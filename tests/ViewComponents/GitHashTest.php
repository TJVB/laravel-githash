<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Tests\ViewComponents;

use Illuminate\Foundation\Testing\WithFaker;
use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\LaravelGitHash\Tests\Fixtures\FakeGitHashLoader;
use TJVB\LaravelGitHash\Tests\TestCase;
use TJVB\LaravelGitHash\ViewComponents\GitHash;

final class GitHashTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function weCanRenderWithAHash(): void
    {
        // setup / mock
        $hash = $this->faker->sha1;
        $loader = new FakeGitHashLoader();
        $loader->hash = $hash;

        // run
        $component = $this->app->make(GitHash::class, [
            'hashLoader' => $loader,
        ]);
        $result = $component->render();

        // verify/assert
        $this->assertStringContainsString($hash, $result->render());
    }

    /**
     * @test
     */
    public function weDontCrashOnAGitHashException(): void
    {
        // setup / mock
        $hash = $this->faker->sha1;
        $exception = new GitHashException('test exception');
        $loader = new FakeGitHashLoader();
        $loader->hash = $hash;
        $loader->exception = $exception;

        // run
        $component = $this->app->make(GitHash::class, [
            'hashLoader' => $loader,
        ]);
        $result = $component->render();

        // verify/assert
        $this->assertStringNotContainsString($hash, $result->render());
    }

    /**
     * @test
     * @dataProvider versionsProvider
     */
    public function weShowOnlyTheWantedVersion(?string $version, bool $showShort, bool $showLong): void
    {
        // setup / mock
        $hash = $this->faker->sha1;
        $loader = new FakeGitHashLoader();
        $loader->hash = $hash;
        $short = $loader->getGitHash()->short();

        // run
        $component = $this->app->make(GitHash::class, [
            'hashLoader' => $loader,
            'version' => $version,
        ]);
        $result = $component->render();

        // verify/assert
        if ($showShort) {
            $this->assertStringContainsString($short, $result->render());
        }
        if ($showLong) {
            $this->assertStringContainsString($hash, $result->render());
        } else {
            $this->assertStringNotContainsString($hash, $result->render());
        }
    }

    public static function versionsProvider(): array
    {
        return [
            'null version' => [null, true, true],
            'short version' => ['short', true, false],
            'long version' => ['long', false, true],
            'empty version' => ['', true, true],
            'other version' => ['other', true, true],
        ];
    }
}
