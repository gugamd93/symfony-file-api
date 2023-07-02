<?php

namespace App\Service\Contract;

interface ServerDataProviderInterface
{
    function getServerData(): array;
}