<?php

namespace FreePik\Domain\Services\CountryEvaluator\Rules;

use FreePik\Domain\Model\Country;

class PopulationRule implements IRule
{

    public static function check(Country $countryToCheck, Country $countryToCompareWith): bool
    {
        if($countryToCheck->getRegion() == 'Asia') {
            return $countryToCheck->getPopulation() >= 8000000;
        }

        return $countryToCheck->getPopulation() >= 50000000;
    }
}
