<?php

namespace App\Model;

use App\Model\Contract\CustomModelInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * This class represents the rows from the file database.
 * All operations about the fields, like reading and
 * extracting values, are performed through this class
 */
class ServerRow
{
    private array $_data;

    private string $model;
    private string $fullRamDescription;
    private string $totalRam;
    private string $fullStorageDescription;
    private string $totalStorage;
    private string $storageType;
    private string $location;
    private string $price;

    public function __construct(array $data)
    {
        $this->_data = $data;
        $this->totalStorage = '0';
        $this->model = '';
    }

    /**
     * @return string
     */
    public function getFullRamDescription(): string
    {
        return $this->fullRamDescription;
    }

    /**
     * @param string $fullRamDescription
     * @return ServerRow
     */
    public function setFullRamDescription(string $fullRamDescription): ServerRow
    {
        $this->fullRamDescription = $fullRamDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalRam(): string
    {
        return $this->totalRam;
    }

    /**
     * @param string $totalRam
     * @return ServerRow
     */
    public function setTotalRam(string $totalRam): ServerRow
    {
        $this->totalRam = $totalRam;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullStorageDescription(): string
    {
        return $this->fullStorageDescription;
    }

    /**
     * @param string $fullStorageDescription
     * @return ServerRow
     */
    public function setFullStorageDescription(string $fullStorageDescription): ServerRow
    {
        $this->fullStorageDescription = $fullStorageDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalStorage(): string
    {
        return $this->totalStorage;
    }

    /**
     * @param string $totalStorage
     * @return ServerRow
     */
    public function setTotalStorage(string $totalStorage): ServerRow
    {
        $this->totalStorage = $totalStorage;
        return $this;
    }

    /**
     * @return string
     */
    public function getStorageType(): string
    {
        return $this->storageType;
    }

    /**
     * @param string $storageType
     * @return ServerRow
     */
    public function setStorageType(string $storageType): ServerRow
    {
        $this->storageType = $storageType;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return ServerRow
     */
    public function setLocation(string $location): ServerRow
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return ServerRow
     */
    public function setModel(string $model): ServerRow
    {
        $this->model = $model;
        return $this;
    }

    public function build(): self
    {
        [$model, $ram, $hdd, $location, $price] = $this->getData();

        $this->setModel($model);
        $this->setFullRamDescription($ram);
        $this->setFullStorageDescription($hdd);
        $this->setLocation($location);
        $this->setPrice($price);
        $this->extractValues();

        return $this;
    }

    private function extractValues(): self
    {
        $this->extractTotalRam()
            ->extractStorageType()
            ->extractTotalStorage();

        return $this;
    }

    /**
     * This method is responsible for extracting the raw storage values
     * and converting them into the appropriate format:
     * 0, 250GB, 500GB, 1TB, 2TB, 3TB, 4TB, 8TB, 12TB, 24TB, 48TB, 72TB
     * To achieve that, we need to convert the storage amount to GB and make
     * an inference by approximating the value to one of the values above
     * @return self
     */
    private function extractTotalStorage(): self
    {
        $capacities = [
            'GB' => 1,
            'TB' => 1024,
        ];

        preg_match('/(\d+)x(\d+)([A-Z]{2})/', $this->getFullStorageDescription(), $matches);
        $quantity = (int) $matches[1];
        $capacity = (int) $matches[2];
        $unit = $matches[3];

        // Convert the capacity to GB
        $capacityInGB = $capacity * $capacities[$unit];

        // Calculate the total storage
        $totalStorage = $quantity * $capacityInGB;

        $outputOptions = [
            0,
            250,
            500,
            1024,
            2048,
            3072,
            4096,
            8192,
            12288,
            24576,
            49152,
            73728,
        ];

        $closestOption = null;
        $minDifference = PHP_INT_MAX;

        // Approximation of the storage to the given list
        foreach ($outputOptions as $option) {
            $difference = abs($option - $totalStorage);
            if ($difference < $minDifference) {
                $minDifference = $difference;
                $closestOption = $option;
            }
        }

        // Determine the display type (GB/TB)
        if ($closestOption >= 1024) {
            $closestOption = $closestOption / 1024;
            $this->setTotalStorage($closestOption . 'TB');
        } else {
            $this->setTotalStorage($closestOption . 'GB');
        }

        return $this;
    }

    private function extractStorageType(): self
    {
        $description = $this->getFullStorageDescription();
        $type = match (true) {
            str_contains($description, 'SSD') => 'SSD',
            str_contains($description, 'SATA') => 'SATA',
            default => 'SAS',
        };

        $this->setStorageType($type);

        return $this;
    }

    private function extractTotalRam(): self
    {
        preg_match('/\d+GB/',$this->getFullRamDescription(),$matches);
        $this->setTotalRam($matches[0]);

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }

    /**
     * @param array $data
     * @return ServerRow
     */
    public function setData(array $data): ServerRow
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return ServerRow
     */
    public function setPrice(string $price): ServerRow
    {
        $this->price = $price;
        return $this;
    }
}
