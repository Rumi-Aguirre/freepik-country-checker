<?php

namespace Tests\Domain;

use FreePik\Domain\Model\Country;
use FreePik\Domain\Services\CountryEvaluator\CountryEvaluator;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CountryEvaluatorTest extends MockeryTestCase
{

    private $argCountry;
    private $norCountry;
    private $countryEvaluator;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    private function setResources()
    {
        $this->countryEvaluator = new CountryEvaluator();
        $this->argCountry = Mockery::mock(Country::class, function($mock) {
            $mock->shouldReceive('getCode')->andReturn('ARG');
            $mock->shouldReceive('getRegion')->andReturn('South America');
            $mock->shouldReceive('getPopulation')->andReturn(60000000);
        });

        $this->norCountry = Mockery::mock(Country::class, function($mock) {
            $mock->shouldReceive('getCode')->andReturn('NOR');
            $mock->shouldReceive('getRegion')->andReturn('Europe');
            $mock->shouldReceive('getPopulation')->andReturn(100);
        });
    }

    public function testCodeRuleReturnsTrueWhenCodeStartsWithVowl(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->argCountry, $this->norCountry);

        $this->assertTrue($result['criteria']['code']);
    }

    public function testCodeRuleReturnsFalseWhenCodeDontsStartsWithVowl(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->norCountry, $this->argCountry);

        $this->assertFalse($result['criteria']['code']);
    }

    public function testPopulationRuleReturnsTrue(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->argCountry, $this->norCountry);

        $this->assertTrue($result['criteria']['population']);
    }


    public function testPopulationRuleReturnsFalse(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->norCountry, $this->argCountry);

        $this->assertFalse($result['criteria']['population']);
    }

    public function testRegionRuleReturnsTrueWhenRegionIsEurope(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->norCountry, $this->argCountry);

        $this->assertFalse($result['criteria']['population']);
    }

    public function testRegionRuleReturnsFalseWhenRegionIsNotEurope(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->norCountry, $this->argCountry);

        $this->assertTrue($result['criteria']['region']);
    }

    public function testRivalRule(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->argCountry, $this->norCountry);

        $this->assertFalse($result['criteria']['region']);
    }

    public function testResultIsTrueWhenAllCriteriasAreTrue(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->argCountry, $this->norCountry);

        $this->assertFalse($result['result']);
    }

    public function testResultIsFalseWhenSomeCriteriasAreFalse(): void
    {
        $this->setResources();
        $result = $this->countryEvaluator->perfomEvaluation($this->norCountry, $this->argCountry);

        $this->assertFalse($result['result']);
    }
}
