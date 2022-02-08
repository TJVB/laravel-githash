<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash;

use Illuminate\Contracts\Config\Repository;
use TJVB\GitHash\Contracts\FinderFactory;
use TJVB\GitHash\Contracts\GitHashRetriever;
use TJVB\GitHash\Values\GitHash;

final class HashLoader implements Contracts\GitHashLoader
{
    public function __construct(
        private Repository $config,
        private FinderFactory $finderFactory,
        private GitHashRetriever $retriever
    ) {
    }

    public function getGitHash(): GitHash
    {
        $enabled = $this->config->get('githash.cache_enabled');
        if ($enabled === null) {
            $enabled = !$this->config->get('app.debug');
        }
        if (!$enabled) {
            return $this->getFreshHash();
        }
        $cacheFile = $this->config->get('githash.cache_file', storage_path('githash.cache'));
        $hashContent = $this->getCacheContent($cacheFile);
        if ($hashContent !== null) {
            return new GitHash($hashContent);
        }

        $hash = $this->getFreshHash();
        $this->storeCacheContent($cacheFile, $hash->hash());

        return $hash;
    }

    private function getFreshHash(): GitHash
    {
        $finders = $this->config->get('githash.finders', []);
        foreach ($finders as $finder) {
            $this->finderFactory->register($finder);
        }
        if (count($finders) === 0) {
            $this->finderFactory->registerDefaultFinders();
        }
        $this->retriever->setFinderFactory($this->finderFactory);
        return $this->retriever->getHash($this->config->get('githash.path', base_path()));
    }

    private function getCacheContent($cacheFile): string|null
    {
        if (!file_exists($cacheFile)) {
            return null;
        }
        $content = file_get_contents($cacheFile);
        if ($content === false) {
            return null;
        }
        return $content;
    }

    private function storeCacheContent(string $cacheFile, string $content): void
    {
        file_put_contents($cacheFile, $content);
    }
}
