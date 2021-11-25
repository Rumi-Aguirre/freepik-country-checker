<?php

namespace Tests\Infrastructure;

use FreePik\Domain\Exceptions\RapidApiCountryApiCallException;
use FreePik\Domain\Exceptions\RapidApiCoutryApiResponseValidationException;
use FreePik\Domain\Model\Country;
use FreePik\Infrastructure\CountryApi\RapidApiCountryApi;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class RapidApiCountryApiTest extends MockeryTestCase
{

    protected function tearDown(): void
    {
        Mockery::close();
    }

    
    public function testSuccessGetCountry()
    {
        $rapidCountryApi = Mockery::mock(RapidApiCountryApi::class)->makePartial();
        $rapidCountryApi->shouldAllowMockingProtectedMethods()->shouldReceive('makeRequest')
            ->andReturn(
                '[{
                    "name": "Colombia",
                    "capital": "Bogotá",
                    "relevance": "0",
                    "region": "Americas",
                    "subregion": "South America",
                    "population": 47330000,
                    "demonym": "Colombian",
                    "area": 1141748,
                    "gini": 55.9,
                    "alpha2Code": "CO",
                    "alpha3Code": "COL"
                }]'
            );

        $country = $rapidCountryApi->getByCode('col');

        $this->assertInstanceOf(Country::class, $country);
    }
    

    public function testThrowRapidApiCountryApiCallException()
    {
        $this->expectException(RapidApiCountryApiCallException::class);

        $rapidCountryApi = Mockery::mock(RapidApiCountryApi::class)->makePartial();
        $rapidCountryApi->shouldAllowMockingProtectedMethods()->shouldReceive('makeRequest')
            ->andThrow(new RapidApiCountryApiCallException());

        $rapidCountryApi->getByCode('col');
    }

    public function testThrowRapidApiCoutryApiResponseValidationException()
    {
        $this->expectException(RapidApiCoutryApiResponseValidationException::class);

        $rapidCountryApi = Mockery::mock(RapidApiCountryApi::class)->makePartial();
        $rapidCountryApi->shouldAllowMockingProtectedMethods()->shouldReceive('makeRequest')
            ->andReturn('invalid data');

        $rapidCountryApi->getByCode('col');
    }
}
