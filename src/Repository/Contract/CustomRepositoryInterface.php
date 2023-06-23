<?php

namespace App\Repository\Contract;

interface CustomRepositoryInterface
{
    function load(): self;
    function get(bool $flushCache = false): array;
    function filter(array $filterCondition): array;
}