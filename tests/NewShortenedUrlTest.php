<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NewShortenedUrlTest extends WebTestCase
{
    private static ?KernelBrowser $baseClient = null;

    protected function setUp(): void
    {
        parent::setUp();

        if (self::$baseClient === null) {
            self::$baseClient = static::createClient();
            self::$baseClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ]);
        }
    }

    public function testSomething(): void
    {
        self::$baseClient->request('POST', '/new', [], [], [], json_encode([
            'data' => [
                'original-url' => 'https://www.google.com/'
            ]
        ], JSON_THROW_ON_ERROR));

        $response = self::$baseClient->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertResponseHasHeader('content-type', 'application/json');

        self::assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('shortened-url', $responseData);

        self::assertStringMatchesFormat('http%S//%s/%s', $responseData['shortened-url']);
        self::assertMatchesRegularExpression('/\/[A-Za-z0-9]{7}$/', $responseData['shortened-url']);
    }
}
