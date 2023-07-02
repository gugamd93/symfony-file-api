<?php

namespace App\Tests\Unit\Model;

use App\Service\Contract\PathProviderInterface;
use App\Service\Contract\ServerRowFactoryServiceInterface;
use PHPUnit\Framework\TestCase;
use App\Model\ServerModel;
use App\Model\ServerRow;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServerModelTest extends KernelTestCase
{

    private function getModel(): ServerModel
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var ServerRowFactoryServiceInterface $factoryService */
        $factoryService = $container->get(ServerRowFactoryServiceInterface::class);

        /** @var PathProviderInterface $filePathService */
        $filePathService = $container->get(PathProviderInterface::class);

        return new ServerModel($filePathService, $factoryService);
    }

    private function filterModel(array $filters): array
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        return $model->filter($filters);
    }

    public function testLoad(): void
    {
        $model = $this->getModel();

        $model->load();

        $data = $model->getData();

        $this->assertNotNull($data);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data[0]);
    }

    public function testBuildData(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $builtData = $model->getBuiltData();

        $this->assertNotNull($builtData);
        $this->assertIsArray($builtData);
        $this->assertNotEmpty($builtData);
        $this->assertInstanceOf(ServerRow::class, $builtData[0]);
    }

    public function testFilterEmpty(): void
    {
        $filters = [];

        $filteredData = $this->filterModel($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(486, $filteredData);

        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterLocationAmsterdam(): void
    {
        $filters = ['Location' => 'AmsterdamAMS-01'];

        $filteredData = $this->filterModel($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(105, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterLocationWashington(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Location' => 'Washington D.C.WDC-01'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(126, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterHddTypeSATA(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Harddisk type' => 'SATA'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(273, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterHddTypeSAS(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Harddisk type' => 'SAS'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(11, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterHddTypeSSD(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Harddisk type' => 'SSD'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(202, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterStorage0GB(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Storage' => '0GB'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(19, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterStorage500GB(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Storage' => '500GB'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(3, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterStorage4TB(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Storage' => '4TB'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(43, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterStorage24TB(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Storage' => '24TB'];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(31, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterRAM2GB(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Ram' => ['2GB']];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertEmpty($filteredData);
        $this->assertCount(0, $filteredData);
    }

    public function testFilterRAM8GB(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Ram' => ['8GB']];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(35, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterRAMAllOptions(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = ['Ram' => [
            '2GB',
            '4GB',
            '8GB',
            '12GB',
            '16GB',
            '24GB',
            '32GB',
            '48GB',
            '64GB',
            '96GB',
        ]];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(381, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testFilterAll(): void
    {
        $model = $this->getModel();

        $model->load();
        $model->buildData();

        $filters = [
            'Ram' => [
                '4GB',
                '16GB',
                '32GB',
            ],
            'Storage' => '1TB',
            'Harddisk type' => 'SATA',
            'Location' => 'AmsterdamAMS-01'
        ];

        $filteredData = $model->filter($filters);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertCount(5, $filteredData);
        $this->assertCount(5, $filteredData[0]);
        $this->assertArrayHasKey('Model', $filteredData[0]);
        $this->assertArrayHasKey('RAM', $filteredData[0]);
        $this->assertArrayHasKey('HDD', $filteredData[0]);
        $this->assertArrayHasKey('Location', $filteredData[0]);
        $this->assertArrayHasKey('Price', $filteredData[0]);
    }

    public function testGetData(): void
    {
        $model = $this->getModel();

        $data = $model->getData();

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertCount(486, $data);
    }
}
