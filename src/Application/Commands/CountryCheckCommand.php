<?php

namespace FreePik\Application\Commands;

use Freepik\Application\Commands\CountryCheckDto;
use FreePik\Application\Interfaces\ICommand;
use FreePik\Domain\Services\CountryEvaluator\CountryEvaluator;
use FreePik\Infrastructure\CountryApi\ICountryApi;

class CountryCheckCommand implements ICommand
{

    private ICountryApi $countryApi;

    public function __construct(ICountryApi $countryApi)
    {
        $this->countryApi = $countryApi;
    }

    public function handle(CountryCheckDto $countryCheckDto)
    {
        $countryData = $this->countryApi->getByCode($countryCheckDto->getCountryCode());
        $rivalData = $this->countryApi->getByCode("NOR");

        $countryEvaluator = new CountryEvaluator();
        $result = $countryEvaluator->perfomEvaluation($countryData, $rivalData);

        return $result;
    }
}
