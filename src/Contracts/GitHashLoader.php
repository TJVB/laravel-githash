<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Contracts;

use TJVB\GitHash\Values\GitHash;

interface GitHashLoader
{
    public function getGitHash(): GitHash;
}
