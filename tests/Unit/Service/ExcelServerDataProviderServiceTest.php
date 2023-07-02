<?php

namespace App\Tests\Unit\Service;

use App\Service\Contract\ServerDataProviderInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExcelServerDataProviderServiceTest extends KernelTestCase
{
    public function testGetServerData(): void
    {
        static::bootKernel();
        $container = static::getContainer();

        /** @var ServerDataProviderInterface $dataProvider */
        $dataProvider = $container->get(ServerDataProviderInterface::class);

        $data = $dataProvider->getServerData();

        $this->assertCount(486, $data);
    }
}