<?php

namespace App\Service;

use App\Model\ServerRow;
use App\Service\Contract\ServerRowFactoryInterface;

class ServerRowFactoryService implements ServerRowFactoryInterface
{
    function createObject(array $data = []): ServerRow
    {
        return new ServerRow($data);
    }
}