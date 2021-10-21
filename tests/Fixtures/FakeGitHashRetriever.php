<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Tests\Fixtures;

use Exception;
use TJVB\GitHash\Contracts\FinderFactory;
use TJVB\GitHash\Contracts\GitHashRetriever;
use TJVB\GitHash\Values\GitHash;

class FakeGitHashRetriever implements GitHashRetriever
{
    public string $hash = '355d4717c0e7ec57e6ed60f9b35ee071909d128b';
    public ?Exception $exception = null;
    public ?FinderFactory $finderFactory = null;
    public function setFinderFactory(FinderFactory $finderFactory): void
    {
        $this->finderFactory = $finderFactory;
    }

    public function getHash(string $path): GitHash
    {
        if ($this->exception !== null) {
            throw $this->exception;
        }
        return new GitHash($this->hash);
    }

    public function getHashAndIgnoreFailures(string $path): GitHash
    {
        if ($this->exception !== null) {
            throw $this->exception;
        }
        return new GitHash($this->hash);
    }
}
