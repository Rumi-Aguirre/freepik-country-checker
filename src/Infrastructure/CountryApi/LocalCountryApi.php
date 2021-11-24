<?php

namespace FreePik\Infrastructure\CountryApi;

use Exception;
use FreePik\Domain\Model\Country;

class LocalCountryApi implements ICountryApi {

    public function getByCode(string $code) : Country
    {
        $filename = __DIR__ . '/LocalCountryApiResponses/' . $code . '.json';

        if(file_exists($filename) === false) {
            throw new Exception('code not found', 404);
        }

        $response = json_decode(file_get_contents($filename));

        return new Country($response->alpha2Code, $response->region, $response->population);
    }

}