<?php

use Slim\Factory\AppFactory;
use DI\Container;
use DI\ContainerBuilder;
use FreePik\Infrastructure\CountryApi\ICountryApi;
use FreePik\Infrastructure\CountryApi\LocalCountryApi;
use FreePik\Infrastructure\CountryApi\RapidApiCountryApi;
use FreePik\Infrastructure\Exceptions\ErrorHandler;
use FreePik\Infrastructure\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

$settings = require(__DIR__ . '/../config/settings.php');

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    ICountryApi::class => function (ContainerInterface $container) {
        // return new RapidApiCountryApi(); # RapidApi seems to be broken at development time so I use a local implementation of CountryApi instead
        return new LocalCountryApi();
    },

    LoggerFactory::class => function (ContainerInterface $container) use ($settings) {
        return new LoggerFactory($settings['logging']);
    },
]);

AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

$loggerFactory = $app->getContainer()->get(LoggerFactory::class);
$logger = $loggerFactory->addFileHandler('error.log')->createLogger();

$errorMiddleware = $app->addErrorMiddleware(
    $settings['error']['display_error_details'],
    $settings['error']['log_errors'],
    $settings['error']['log_error_details'],
    $logger
);
$errorMiddleware->setDefaultErrorHandler(ErrorHandler::class);

(require __DIR__ . '/../config/routes.php')($app);

$app->run();
