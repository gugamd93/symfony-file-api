<?php

namespace App\Tests\Unit\Service;

use App\Model\ServerRow;
use App\Service\Contract\ServerRowFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ServerRowFactoryServiceTest extends KernelTestCase
{
    public function testCreateObject(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        /** @var ServerRowFactoryInterface $service */
        $service = $container->get(ServerRowFactoryInterface::class);

        $object = $service->createObject([]);
        $expectedObject = ServerRow::class;
        $this->assertInstanceOf($expectedObject, $object);
    }
}
