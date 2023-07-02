<?php

namespace App\Service;

use App\Service\Contract\PathProviderInterface;

class ServerFilePathService implements PathProviderInterface
{
    public function __construct(private readonly string $databaseFilePath)
    {
    }

    public function getPath(): string
    {
//        return '../data/LeaseWeb.xlsx';
        return $this->databaseFilePath;
    }
}