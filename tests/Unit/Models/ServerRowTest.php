<?php
namespace App\Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Model\ServerRow;

class ServerRowTest extends TestCase
{
    public function testBuild(): void
    {
        $data = [
            'Dell R210-IIIntel G530',
            '4GBDDR3',
            '2x500GBSATA2',
            'AmsterdamAMS-01',
            '€60.99',
        ];

        $serverRow = new ServerRow($data);
        $serverRow->build();

        $this->assertSame('Dell R210-IIIntel G530', $serverRow->getModel());
        $this->assertSame('4GBDDR3', $serverRow->getFullRamDescription());
        $this->assertSame('2x500GBSATA2', $serverRow->getFullStorageDescription());
        $this->assertSame('AmsterdamAMS-01', $serverRow->getLocation());
        $this->assertSame('€60.99', $serverRow->getPrice());
        $this->assertSame('4GB', $serverRow->getTotalRam());
        $this->assertSame('1TB', $serverRow->getTotalStorage());
        $this->assertSame('SATA', $serverRow->getStorageType());
    }

    public function testToArray(): void
    {
        $data = [
            'Dell R210-IIIntel G530',
            '4GBDDR3',
            '2x500GBSATA2',
            'AmsterdamAMS-01',
            '€60.99',
        ];

        $serverRow = new ServerRow($data);
        $serverRow->build();
        $serverRowArray = $serverRow->toArray();

        $expectedArray = [
            'Model' => 'Dell R210-IIIntel G530',
            'RAM' => '4GBDDR3',
            'HDD' => '2x500GBSATA2',
            'Location' => 'AmsterdamAMS-01',
            'Price' => '€60.99',
        ];

        $this->assertSame($expectedArray, $serverRowArray);
    }
}
