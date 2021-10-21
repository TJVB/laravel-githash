<?php

declare(strict_types=1);

namespace TJVB\LaravelGitHash\Contracts;

interface LogContextEnricher
{

    public function enrich(): void;
}
