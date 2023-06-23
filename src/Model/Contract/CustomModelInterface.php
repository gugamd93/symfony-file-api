<?php

namespace App\Model\Contract;

interface CustomModelInterface
{
    function load(): self;
    function buildData(): self;
    function getData(bool $flush = false): array;
    function filter(array $filterCondition): array;
}
