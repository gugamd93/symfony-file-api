<?php

namespace App\Service\Contract;

interface PathProviderInterface
{
    public function getPath(): string;
}