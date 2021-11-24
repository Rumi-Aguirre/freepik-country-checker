<?php

namespace FreePik\Domain\Services\CountryEvaluator\Rules;

use FreePik\Domain\Model\Country;

interface IRule {

    public static function check(Country $countryToCheck, Country $countryToCompareWith) : bool;

}