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
        $responseData = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode()
        ];
        
        if($displayErrorDetails) {
            $responseData['trace'] = $exception->getTrace();
        }

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write(json_encode($responseData));

        $httpCode = 500;
        if($exception->getCode() >= 100 && $exception->getCode() < 600) {
            $httpCode = $exception->getCode();
        }

        if($logErrors) {
            $logLine = $exception->getMessage() . '|Code:' . $exception->getCode();
            if($logErrorDetails) {
                $logLine .= '|Trace:' . $exception->getTraceAsString();
            } 
            $this->logger->error($logLine);
        }

        return $response->withStatus($httpCode);
    }
}
