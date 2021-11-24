<?php

namespace FreePik\Domain\Services\CountryEvaluator\Rules;

use FreePik\Domain\Model\Country;

class CodeRule implements IRule
{

    public static function check(Country $countryToCheck, Country $countryToCompareWith): bool
    {
        return preg_match('/^[aeiou]/i', $countryToCheck->getCode());
    }
}
