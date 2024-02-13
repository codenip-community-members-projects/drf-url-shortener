<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class NewShortenedUrlTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('POST', '/new', [], [], [], json_encode([
            'data' => [
                'original-url' => 'https://www.google.com/'
            ]
        ], JSON_THROW_ON_ERROR));

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        // Test response key
        // Test response value format
        // Test response random code format (ex. length)
        // self::assertJsonStringEqualsJsonString();
    }
}
