<?php

namespace FreePik\Infrastructure\CountryApi;

use FreePik\Domain\Exceptions\RapidApiCountryApiCallException;
use FreePik\Domain\Exceptions\RapidApiCoutryApiResponseValidationException;
use FreePik\Domain\Model\Country;
use League\JsonGuard\Validator;

class RapidApiCountryApi implements ICountryApi
{

    public function getByCode(string $code): Country
    {
        $response = $this->makeRequest($code);

        $data = json_decode($response);
        $schema = json_decode('{ "type": "object", "properties": { "alpha3Code": { "type": "string"}, "region": { "type": "string"}, "population": { "type": "integer"}} }');
        $validator = new Validator($data, $schema);

        if ($validator->fails()) {
            throw new RapidApiCoutryApiResponseValidationException();
        }

        return new Country($data->alpha3Code, $data->region, $data->population);
    }

    protected function makeRequest($code)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://restcountries-v1.p.rapidapi.com/alpha/?codes=$code",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: restcountries-v1.p.rapidapi.com",
                "x-rapidapi-key: 99f978231fmshfccbdae45887367p1544fejsnbe1055342ebe"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new RapidApiCountryApiCallException($err);
        }

        return $response;
    }
}
