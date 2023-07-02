<?php

namespace App\Tests\Unit\Service;

use App\Model\ServerRow;
use App\Service\Contract\ServerRowFactoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ServerRowFactoryServiceTest extends KernelTestCase
{
    public function testCreateObject(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        /** @var ServerRowFactoryServiceInterface $service */
        $service = $container->get(ServerRowFactoryServiceInterface::class);

        $object = $service->createObject([]);
        $expectedObject = ServerRow::class;
        $this->assertInstanceOf($expectedObject, $object);
    }
}
