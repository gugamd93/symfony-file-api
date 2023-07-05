<?php

namespace App\Tests\Unit\Repository;

use App\Model\ServerRow;
use PHPUnit\Framework\TestCase;
use App\Repository\ServerRepository;
use App\Model\Contract\CustomModelInterface;

class ServerRepositoryTest extends TestCase
{
    public function testGet(): void
    {
        $model = $this->createMock(CustomModelInterface::class);
        $model->expects($this->once())
            ->method('getData')
            ->with(false)
            ->willReturn(['data']);

        $repository = new ServerRepository($model);
        $result = $repository->get();

        $this->assertEquals(['data'], $result);
    }

    public function testGetWithFlushCache(): void
    {
        $model = $this->createMock(CustomModelInterface::class);
        $model->expects($this->once())
            ->method('getData')
            ->with(true)
            ->willReturn(['data']);

        $repository = new ServerRepository($model);
        $result = $repository->get(true);

        $this->assertEquals(['data'], $result);
    }

    public function testFilter(): void
    {
        $filterCondition = ['key' => 'value'];

        $model = $this->createMock(CustomModelInterface::class);
        $mockServerRow = [new ServerRow([])];
        $model->expects($this->once())
            ->method('filter')
            ->with($filterCondition)
            ->willReturn($mockServerRow);

        $repository = new ServerRepository($model);
        $result = $repository->filter($filterCondition);

        $this->assertEquals($mockServerRow, $result);
    }

    public function testLoad(): void
    {
        $model = $this->createMock(CustomModelInterface::class);
        $model->expects($this->once())
            ->method('load')
            ->willReturnSelf();

        $model->expects($this->once())
            ->method('buildData');

        $repository = new ServerRepository($model);
        $result = $repository->load();

        $this->assertSame($repository, $result);
    }
}
