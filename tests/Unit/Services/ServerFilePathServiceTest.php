<?php

namespace App\Tests\Unit\Services;

use App\Service\ServerFilePathService;

use PHPUnit\Framework\TestCase;


class ServerFilePathServiceTest extends TestCase
{
    public function testGetPath(): void
    {
        $service = new ServerFilePathService();

        $path = $service->getPath();
        $expectedPath = '../data/LeaseWeb.xlsx';
        $this->assertEquals($expectedPath, $path);
    }
}