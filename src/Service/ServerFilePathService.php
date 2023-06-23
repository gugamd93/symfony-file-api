<?php

namespace App\Service;

use App\Service\Contract\PathProviderInterface;

class ServerFilePathService implements PathProviderInterface
{

    public function getPath(): string
    {
        return '../data/LeaseWeb.xlsx';
    }
}