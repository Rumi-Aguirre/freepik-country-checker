<?php

namespace FreePik\Infrastructure\Ui\Http\Handlers;

use FreePik\Application\Commands\CountryCheckCommand;
use FreePik\Application\Commands\CountryCheckDto;
use FreePik\Infrastructure\Ui\Http\Validators\CountryCheckHandlerValidator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class CountryCheckHandler
{

    private CountryCheckCommand $countryCheckCommand;

    public function __construct(CountryCheckCommand $countryCheckCommand)
    {
        $this->countryCheckCommand = $countryCheckCommand;
    }

    /**
     * @OA\Get(
     *     tags={"Country"},
     *     path="/country-check",
     *     operationId="countryCheckCommand",
     *     @OA\Parameter(name="country-code",
        *     in="query",
        *     required=true,
        *     @OA\Schema(type="string")
        *   ),
     *     @OA\Response(
     *      response="200",
     *      description="Return a summary of country criterias"
     *     )
     * )
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();

        CountryCheckHandlerValidator::validate($params);

        $countryCheckDto = new CountryCheckDto($params['country-code']);
        $result = $this->countryCheckCommand->handle($countryCheckDto);

        $response->getBody()->write(json_encode($result));

        return $response->withHeader('Content-type', 'application/json');
    }
}
