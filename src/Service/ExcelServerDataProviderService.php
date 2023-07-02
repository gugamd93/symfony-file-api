<?php

namespace App\Service;

use App\Service\Contract\PathProviderInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelServerDataProviderService implements Contract\ServerDataProviderInterface
{
    public function __construct(
        private readonly PathProviderInterface $serverFilePathService
    )
    {
    }

    function getServerData(): array
    {
        // Create a new Spreadsheet object from XLSX file
        $spreadsheet = IOFactory::load($this->serverFilePathService->getPath());

        // Get the first worksheet from spreadsheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Get all rows from worksheet
        $allRows = $worksheet->toArray();

        // Remove first item from array (labels row)
        array_shift($allRows);

        return $allRows;
    }
}