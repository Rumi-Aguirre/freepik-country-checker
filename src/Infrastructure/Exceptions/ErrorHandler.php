<?php

namespace FreePik\Infrastructure\Exceptions;

use FreePik\Infrastructure\Logger\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Throwable;

class ErrorHandler
{

    private ResponseFactory $responseFactory;

    private $logger;

    public function __construct(ResponseFactory $responseFactory, LoggerFactory $loggerFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->logger = $loggerFactory->addFileHandler('freepik.log')->createLogger();
    }

    public function __invoke(ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails) : ResponseInterface
    {
        $response = $this->responseFactory->createResponse();
        $response->getBody()->write(json_encode([
            'message' => $exception->getMessage(),
            'code' => $exception->getCode()
        ]));

        $this->logger->error($exception->getMessage() . '|Code:' . $exception->getCode());
        
        return $response->withStatus(500);
    }
}
