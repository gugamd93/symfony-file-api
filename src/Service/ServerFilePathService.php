<?php

namespace App\Service;

use App\Service\Contract\PathProviderInterface;

/**
 * This class is specialized in returning the path to our file database
 * As the path is different for a normal application and for a testing application,
 * so the $databaseFilePath is injected into this service with a value from .env file.
 */
class ServerFilePathService implements PathProviderInterface
{
    public function __construct(private readonly string $databaseFilePath)
    {
    }

    public function getPath(): string
    {
        return $this->databaseFilePath;
    }
}