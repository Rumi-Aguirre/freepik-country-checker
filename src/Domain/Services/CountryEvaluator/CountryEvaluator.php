<?php

namespace FreePik\Domain\Services\CountryEvaluator;

use FreePik\Domain\Model\Country;

class CountryEvaluator {

    private CountryEvaluatorRuleProvider $ruleProvider;

    public function __construct()
    {
        $this->ruleProvider = new CountryEvaluatorRuleProvider();
    }

    public function perfomEvaluation(Country $countryToCheck, Country $countryToCompareWith) 
    {
        $enabledRules = $this->ruleProvider->getEnabledRules();

        $criteria = [];
        $result = true;
        foreach($enabledRules as $ruleName =>  $rule) {
            $criteria[$ruleName] = $rule['handler']::check($countryToCheck, $countryToCompareWith);
            $result = $result && $criteria[$ruleName];
        }

        return [
            'result' => $result,
            'criteria' => $criteria,
        ];
    }

}