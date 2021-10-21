<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash;

use Illuminate\Support\Facades\Log;
use TJVB\LaravelGitHash\Contracts\GitHashLoader;

final class LogEnricher implements Contracts\LogContextEnricher
{

    public function __construct(private GitHashLoader $hashLoader)
    {
    }

    public function enrich(): void
    {
        $gitHash = $this->hashLoader->getGitHash();
        // if we use the DI for the instance we don't get the default one that is used by Laravel so we use the facade
        Log::withContext([
            'githash' => [
                'hash' => $gitHash->hash(),
                'short' => $gitHash->short(),
            ],
        ]);
    }
}
