<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash;

use Illuminate\Log\Logger;
use TJVB\LaravelGitHash\Contracts\GitHashLoader;

class LogEnricher implements Contracts\LogContextEnricher
{

    public function __construct(private Logger $logger, private GitHashLoader $hashLoader)
    {
    }

    public function enrich(): void
    {
        $this->logger->withContext([
            'githash' => [
                'hash' => $this->hashLoader->getGitHash()->hash(),
                'short' => $this->hashLoader->getGitHash()->short(),
            ],
        ]);
    }
}
