<?php

use Slim\App;
use FreePik\Infrastructure\Ui\Http\Handlers\CountryCheckHandler;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/country-check', CountryCheckHandler::class);
};
