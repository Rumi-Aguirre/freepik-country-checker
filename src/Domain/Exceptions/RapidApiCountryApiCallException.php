<?php

namespace FreePik\Domain\Exceptions;

use Exception;

class RapidApiCountryApiCallException extends Exception {

    public function __construct(string $error = null)
    {
        parent::__construct('Error on Api call to RapidAPI: ' . $error, 500);
    }

}