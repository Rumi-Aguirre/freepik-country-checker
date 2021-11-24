<?php

namespace FreePik\Domain\Services\CountryEvaluator\Rules;

use FreePik\Domain\Model\Country;

class RegionRule implements IRule
{

    public static function check(Country $countryToCheck, Country $countryToCompareWith): bool
    {
        return $countryToCheck->getRegion() == 'Europe';
    }
}
