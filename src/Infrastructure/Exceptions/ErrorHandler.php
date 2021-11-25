<?php

namespace FreePik\Infrastructure\Exceptions;

use FreePik\Domain\Exceptions\ValidationErrorException;
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

    public function __invoke(ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails): ResponseInterface
    {
        if ($logErrors) {
            $this->logError($exception, $logErrorDetails);
        }

        $responseData = $this->getResponseData($exception, $displayErrorDetails);

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write(json_encode($responseData));

        $httpCode = 500;
        if ($exception->getCode() >= 100 && $exception->getCode() < 600) {
            $httpCode = $exception->getCode();
        }

        return $response->withStatus($httpCode)->withHeader('Content-type', 'application/json');
    }

    private function getResponseData(Throwable $exception, bool $displayErrorDetails)
    {
        $responseData = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode()
        ];

        if ($displayErrorDetails) {
            $responseData['trace'] = $exception->getTrace();
        }

        if ($exception instanceof ValidationErrorException) {
            $responseData['validation'] = $exception->getValidationErrors();
        }

        return $responseData;
    }

    private function logError(Throwable $exception, bool $logErrorDetails)
    {
        $logLine = $exception->getMessage() . '|Code:' . $exception->getCode();
        if ($logErrorDetails) {
            $logLine .= '|Trace:' . $exception->getTraceAsString();
        }
        $this->logger->error($logLine);
    }
}
