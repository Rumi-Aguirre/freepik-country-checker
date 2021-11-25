<?php

namespace Tests\Infrastructure;

use FreePik\Domain\Exceptions\CountryNotFoundException;
use FreePik\Domain\Model\Country;
use FreePik\Infrastructure\CountryApi\LocalCountryApi;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class LocalCountryApiTest extends MockeryTestCase
{

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testSuccessGetCountry()
    {
        $localCountryApi = new LocalCountryApi();
        $country = $localCountryApi->getByCode('col');

        $this->assertInstanceOf(Country::class, $country);
    }

    public function testThrowCountryNotFoudException()
    {
        $this->expectException(CountryNotFoundException::class);
        $localCountryApi = new LocalCountryApi();
        $localCountryApi->getByCode('fake');
    }
}
