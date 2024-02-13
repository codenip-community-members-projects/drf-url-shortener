<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Shortener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ShortenerController extends AbstractController
{
    public function __construct(private readonly Shortener $shortener)
    {
    }

    #[Route('/')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['Esto tiene que renderizar el formulario para ingresar una URL']);
    }

    #[Route('/new')]
    public function new(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $originalUrl = $body['data']['original-url'];
        $shortenedUrl= $this->shortener->__invoke($originalUrl);

        return new JsonResponse(['shortened-url' => "http://localhost:1000/$shortenedUrl"]);
    }
}
