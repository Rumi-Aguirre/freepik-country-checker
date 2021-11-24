<?php

namespace FreePik\Domain\Services\CountryEvaluator;

use FreePik\Domain\Services\CountryEvaluator\Rules\CodeRule;
use FreePik\Domain\Services\CountryEvaluator\Rules\PopulationRule;
use FreePik\Domain\Services\CountryEvaluator\Rules\RegionRule;
use FreePik\Domain\Services\CountryEvaluator\Rules\RivalRule;

class CountryEvaluatorRuleProvider
{

    private $rules = [
        'code' => [
            'enabled' => true,
            'handler' => CodeRule::class,
        ],
        'region' => [
            'enabled' => true,
            'handler' => RegionRule::class,
        ],
        'population' => [
            'enabled' => true,
            'handler' => PopulationRule::class,
        ],
        'rival' => [
            'enabled' => true,
            'handler' => RivalRule::class,
        ],
    ];


    public function getEnabledRules(): array
    {
        $enabledRules = array_filter($this->rules, function ($value) {

            return ($value['enabled'] === true);
        });

        return $enabledRules;
    }
}
