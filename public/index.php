<?php

use Slim\Factory\AppFactory;
use DI\Container;
use DI\ContainerBuilder;
use FreePik\Infrastructure\CountryApi\ICountryApi;
use FreePik\Infrastructure\CountryApi\LocalCountryApi;
use FreePik\Infrastructure\CountryApi\RapidApiCountryApi;
use FreePik\Infrastructure\Exceptions\ErrorHandler;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    ICountryApi::class => function(ContainerInterface $container) {
        // return new RapidApiCountryApi(); # RapidApi seems to be broken at development time so I use a local implementation of CountryApi instead
        return new LocalCountryApi();
    }
]);

AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(ErrorHandler::class);

(require __DIR__ . '/../config/routes.php')($app);

$app->run();
