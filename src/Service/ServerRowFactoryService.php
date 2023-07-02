<?php

namespace App\Service;

use App\Model\ServerRow;
use App\Service\Contract\ServerRowFactoryServiceInterface;

class ServerRowFactoryService implements ServerRowFactoryServiceInterface
{
    function createObject(array $data = []): ServerRow
    {
        return new ServerRow($data);
    }
}