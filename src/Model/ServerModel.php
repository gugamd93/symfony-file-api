<?php

namespace App\Model;

use App\Model\Contract\CustomModelInterface;
use App\Service\Contract\ServerDataProviderInterface;
use App\Service\Contract\ServerRowFactoryInterface;

class ServerModel implements CustomModelInterface
{
    public function __construct(
        private readonly ServerDataProviderInterface $dataProvider,
        private readonly ServerRowFactoryInterface   $serverRowFactoryService,
    )
    {
    }

    // Attributes
    private ?array $data = null;

    /** @var ServerRow[]|null */
    private ?array $_builtData = null;

    public function load(): self
    {
        $data = $this->dataProvider->getServerData();
        $this->setData($data);

        return $this;
    }

    public function buildData(): self
    {
        $builtData = [];
        foreach ($this->getData() as $row) {
            $newRow = $this->serverRowFactoryService->createObject($row);
            $newRow->build();
            $builtData[] = $newRow;
        }

        $this->setBuiltData($builtData);

        return $this;
    }

    /**
     * @return ServerRow[]
     */
    public function filter(array $filterCondition): array
    {
        $currentData = $this->getBuiltData();
        $filteredData = [];

        foreach ($currentData as $row) {
            if ($this->applyFiltersToRow($row, $filterCondition)) {
                $filteredData[] = $row;
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
        return;
    }

    /**
     * @return ServerRow[]|null
     */
    public function getBuiltData(): ?array
    {
        return $this->_builtData;
    }

    public function setBuiltData(?array $builtData): void
    {
        $this->_builtData = $builtData;
    }

    private function applyFiltersToRow(ServerRow $row, array $filters): bool
    {
        if (empty($filters)) {
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
