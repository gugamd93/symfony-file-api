<?php

namespace App\Service;

use App\Model\ServerRow;
use App\Service\Contract\ServerRowFactoryInterface;

/**
 * This class is specialized in creating ServerRow instances
 */
class ServerRowFactoryService implements ServerRowFactoryInterface
{
    function createObject(array $data = []): ServerRow
    {
        return new ServerRow($data);
    }
}