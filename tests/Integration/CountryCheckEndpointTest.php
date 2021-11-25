<?php

namespace Tests\Integration;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Slim\Psr7\Factory\RequestFactory;

class CountryCheckEndpointTest extends MockeryTestCase
{

    public function testCountryCheckSuccess()
    {
        $requestFactory = new RequestFactory();
        $request = $requestFactory->createRequest('GET', '/country-check?country-code=col');

        $response = getApplication()->handle($request);

        $this->assertEquals($response->getStatusCode(), 200);
    }

    public function testCountryCheckMethodNotAllowed()
    {
        $requestFactory = new RequestFactory();
        $request = $requestFactory->createRequest('POST', '/country-check?country-code=col');

        $response = getApplication()->handle($request);

        $this->assertEquals($response->getStatusCode(), 405);
    }

    public function testCountryCheckCountryCodeDoesntExists()
    {
        $requestFactory = new RequestFactory();
        $request = $requestFactory->createRequest('GET', '/country-check?country-code=fake');

        $response = getApplication()->handle($request);

        $this->assertEquals($response->getStatusCode(), 404);
    }
}
