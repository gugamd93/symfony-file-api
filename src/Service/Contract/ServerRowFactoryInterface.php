<?php

namespace App\Service\Contract;

use App\Model\ServerRow;

interface ServerRowFactoryInterface
{
    function createObject(array $data = []): ServerRow;
}