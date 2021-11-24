<?php

namespace FreePik\Infrastructure\CountryApi;

use FreePik\Domain\Model\Country;

interface ICountryApi {

    public function getByCode(string $code) : Country;

}