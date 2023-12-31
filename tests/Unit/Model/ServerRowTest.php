<?php
namespace App\Tests\Unit\Model;

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

    public function testSetData(): void
    {
        $data = [];
        $newData = ['foo' => 'bar'];
        $serverRow = new ServerRow($data);

        $serverRow->setData($newData);

        $expectedData = $newData;
        $data = $serverRow->getData();

        $this->assertEquals($expectedData, $data);
    }
}
