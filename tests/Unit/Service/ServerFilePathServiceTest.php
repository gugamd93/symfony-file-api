<?php

namespace App\Tests\Unit\Service;

use App\Service\Contract\PathProviderInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ServerFilePathServiceTest extends KernelTestCase
{
    public function testGetPath(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $service = $container->get(PathProviderInterface::class);

        $path = $service->getPath();
        $expectedPath = 'data/LeaseWebTest.xlsx';
        $this->assertEquals($expectedPath, $path);
    }
}
