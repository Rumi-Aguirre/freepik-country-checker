<?php

namespace FreePik\Infrastructure\Ui\Http\Validators;

use Cake\Validation\Validator;
use FreePik\Domain\Exceptions\ValidationErrorException;

class CountryCheckHandlerValidator
{

    public static function validate(array $data)
    {
        $validator = new Validator();
        $validator->requirePresence('country-code')
            ->notEmptyString('country-code');

        $errors = $validator->validate($data);
        if ($errors) {
            throw new ValidationErrorException($errors);
        }

        return true;
    }
}
