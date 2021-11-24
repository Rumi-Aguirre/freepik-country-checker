<?php

namespace FreePik\Infrastructure\Ui\Http\Handlers;

use FreePik\Application\Commands\CountryCheckCommand;
use FreePik\Application\Commands\CountryCheckDto;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class CountryCheckHandler
{

    private CountryCheckCommand $countryCheckCommand;

    public function __construct(CountryCheckCommand $countryCheckCommand)
    {
        $this->countryCheckCommand = $countryCheckCommand;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();
        $countryCheckDto = new CountryCheckDto($params['country-code']);
        $result = $this->countryCheckCommand->handle($countryCheckDto);

        $response->getBody()->write(json_encode($result));

        return $response;
    }
}
