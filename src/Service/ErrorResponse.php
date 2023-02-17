<?php


namespace App\Service;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponse extends ApiResponse
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function response(string $message, int $code, array $params = []): JsonResponse
    {
        $this->logger->error($message, $params);
        return new JsonResponse(['errors' => $message], $code);
    }

}
