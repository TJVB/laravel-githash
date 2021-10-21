<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Tests\Fixtures;

use Exception;
use TJVB\GitHash\Values\GitHash;
use TJVB\LaravelGitHash\Contracts\GitHashLoader;

class FakeGitHashLoader implements GitHashLoader
{
    public string $hash = '355d4717c0e7ec57e6ed60f9b35ee071909d128b';
    public ?Exception $exception = null;
    public function getGitHash(): GitHash
    {
        if ($this->exception !== null) {
            throw $this->exception;
        }
        return new GitHash($this->hash);
    }
}
