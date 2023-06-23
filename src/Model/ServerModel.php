<?php

namespace App\Model;

use App\Model\Contract\CustomModelInterface;
use App\Service\Contract\PathProviderInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ServerModel implements CustomModelInterface
{

    public function __construct(
        private readonly PathProviderInterface $serverFilePathService
    )
    {
    }

    // Attributes
    private ?array $data = null;

    /** @var ServerRow[]|null  */
    private ?array $_builtData = null;

    public function load(): self
    {
        // Create a new Spreadsheet object from XLSX file
        $spreadsheet = IOFactory::load($this->serverFilePathService->getPath());

        // Get the first worksheet from spreadsheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Get all rows from worksheet
        $allRows = $worksheet->toArray();

        // Remove first item from array (labels row)
        array_shift($allRows);
        $this->setData($allRows);

        return $this;
    }

    public function buildData(): self
    {
        foreach ($this->getData() as $row) {
            $newRow = new ServerRow($row);
            $newRow->build();
            $this->_builtData[] = $newRow;
        }

        return $this;
    }

    public function filter(array $filterCondition): array
    {
        $currentData = $this->getBuiltData();
        $filteredData = [];

        foreach($currentData as $row) {
            if($this->applyFiltersToRow($row, $filterCondition)) {
                $filteredData[] = $row->toArray();
            }
        }

        return $filteredData;
    }

    public function getData(bool $flush = false): array
    {
        if ($this->data === NULL || $flush) {
            $this->load();
        }

        return $this->data;
    }

    private function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return ServerRow[]|null
     */
    public function getBuiltData(): ?array
    {
        return $this->_builtData;
    }

    /**
     * @param array|null $builtData
     * @return ServerModel
     */
    public function setBuiltData(?array $builtData): ServerModel
    {
        $this->_builtData = $builtData;
        return $this;
    }

    private function applyFiltersToRow(ServerRow $row, array $filters): bool
    {
        if(empty($filters)) {
            return true;
        }

        $isMatch = true;

        if (isset($filters['Storage'])) {
            $isMatch = $this->applyStorageFilterToRow($row, $filters['Storage']);
        }

        if ($isMatch && isset($filters['Harddisk type'])) {
            $isMatch = $this->applyStorageTypeFilterToRow($row, $filters['Harddisk type']);
        }

        if ($isMatch && isset($filters['Ram'])) {
            $isMatch = $this->applyRamFilterToRow($row, $filters['Ram']);
        }

        if ($isMatch && isset($filters['Location'])) {
            $isMatch = $this->applyLocationFilterToRow($row, $filters['Location']);
        }

        return $isMatch;

    }

    private function applyStorageFilterToRow(ServerRow $row, string $value): bool
    {
        return $row->getTotalStorage() === $value;
    }

    private function applyRamFilterToRow(ServerRow $row, array $value): bool
    {
        return in_array($row->getTotalRam(), $value);
    }

    private function applyStorageTypeFilterToRow(ServerRow $row, string $value): bool
    {
        return $row->getStorageType() === $value;
    }

    private function applyLocationFilterToRow(ServerRow $row, string $value): bool
    {
        return $row->getLocation() === $value;
    }
}
