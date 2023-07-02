<?php

namespace App\Service\Contract;

use App\Model\ServerRow;

interface ServerRowFactoryServiceInterface
{
    function createObject(array $data = []): ServerRow;
}