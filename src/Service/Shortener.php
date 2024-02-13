<?php

declare(strict_types=1);

namespace App\Service;

class Shortener
{
    public function __invoke(string $url): string
    {
        $hashedUrl = md5($url);
        $encodedUrl = base64_encode($hashedUrl);

        return substr($encodedUrl, 0,7);
    }
}
