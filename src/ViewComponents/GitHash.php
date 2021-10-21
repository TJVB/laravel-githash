<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\ViewComponents;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Psr\Log\LoggerInterface;
use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\LaravelGitHash\Contracts\GitHashLoader;

class GitHash extends Component
{

    public function __construct(
        private Factory $viewFactory,
        private GitHashLoader $hashLoader,
        private LoggerInterface $logger
    ) {
    }

    public function render(): View
    {
        $hash = $short = '';
        try {
            $gitHash = $this->hashLoader->getGitHash();
            $hash = $gitHash->hash();
            $short = $gitHash->short();
        } catch (GitHashException $exception) {
            $this->logger->error('Failed to load the hash', [
                'exception' => $exception,
            ]);
        }
        return $this->viewFactory->make('githash::githash')
            ->with('githash', $hash)
            ->with('short', $short)
            ;
    }
}
