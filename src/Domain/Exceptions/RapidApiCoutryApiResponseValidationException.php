<?php

namespace FreePik\Domain\Exceptions;

use Exception;

class RapidApiCoutryApiResponseValidationException extends Exception {

    public function __construct()
    {
        parent::__construct('RapidAPI Coutry Api response doesn\'t match with validator schema', 400);
    }

}