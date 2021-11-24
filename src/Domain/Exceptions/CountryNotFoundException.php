<?php

namespace FreePik\Domain\Exceptions;

use Exception;

class CountryNotFoundException extends Exception {

    public function __construct(string $countryCode)
    {
        parent::__construct('Country not found with code ' . $countryCode, 404);
    }

}