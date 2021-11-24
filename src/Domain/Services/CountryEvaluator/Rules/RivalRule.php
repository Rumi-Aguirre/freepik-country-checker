<?php

namespace FreePik\Domain\Services\CountryEvaluator\Rules;

use FreePik\Domain\Model\Country;

class RivalRule implements IRule
{

    public static function check(Country $countryToCheck, Country $countryToCompareWith): bool
    {
        return $countryToCheck->getPopulation() > $countryToCompareWith->getPopulation();
    }
}
