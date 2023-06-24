<?php

namespace App\Tests\Application\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ServerControllerTest extends WebTestCase
{
    private function filter(array $filter): Response
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/server',
            $filter
        );

        return $client->getResponse();
    }

    public function testIndexNoFilter(): void
    {
        $filter = [];
        $response = $this->filter($filter);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));

        $responseData = json_decode($response->getContent(), true);

        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);
        $this->assertCount(486, $responseData);

        $this->assertCount(5, $responseData[0]);
        $this->assertArrayHasKey('Model', $responseData[0]);
        $this->assertArrayHasKey('RAM', $responseData[0]);
        $this->assertArrayHasKey('HDD', $responseData[0]);
        $this->assertArrayHasKey('Location', $responseData[0]);
        $this->assertArrayHasKey('Price', $responseData[0]);
    }

    public function testIndexFilterAllFilters(): void
    {
        $filter = [
            'filter' => [
                'Ram' => [
                    '4GB',
                    '16GB',
                    '32GB',
                ],
                'Storage' => '1TB',
                'Harddisk type' => 'SATA',
                'Location' => 'AmsterdamAMS-01'
            ]
        ];

        $response = $this->filter($filter);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));

        $responseData = json_decode($response->getContent(), true);

        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);
        $this->assertCount(5, $responseData);

        $this->assertCount(5, $responseData[0]);
        $this->assertArrayHasKey('Model', $responseData[0]);
        $this->assertArrayHasKey('RAM', $responseData[0]);
        $this->assertArrayHasKey('HDD', $responseData[0]);
        $this->assertArrayHasKey('Location', $responseData[0]);
        $this->assertArrayHasKey('Price', $responseData[0]);
    }

    public function testIndexFilterStorageAndRam(): void
    {
        $filter = ['filter' => ['Storage' => '1TB', 'Ram' => ['16GB']]];
        $response = $this->filter($filter);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));

        $responseData = json_decode($response->getContent(), true);

        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);
        $this->assertCount(23, $responseData);

        $this->assertCount(5, $responseData[0]);
        $this->assertArrayHasKey('Model', $responseData[0]);
        $this->assertArrayHasKey('RAM', $responseData[0]);
        $this->assertArrayHasKey('HDD', $responseData[0]);
        $this->assertArrayHasKey('Location', $responseData[0]);
        $this->assertArrayHasKey('Price', $responseData[0]);
    }
}
