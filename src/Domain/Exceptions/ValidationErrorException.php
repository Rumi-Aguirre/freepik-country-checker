<?php

namespace FreePik\Domain\Exceptions;

use Exception;

class ValidationErrorException extends Exception
{

    private $validationErrors;

    public function __construct(array $validationErrors)
    {
        $this->validationErrors = $validationErrors;
        parent::__construct('Validation error', 400);
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
