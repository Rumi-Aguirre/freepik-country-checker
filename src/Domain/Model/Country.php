<?php

namespace FreePik\Domain\Model;

class Country
{

    private string $code;

    private string $region;

    private int $population;

    public function __construct(string $code, string $region, int $population)
    {
        $this->code = $code;
        $this->region = $region;
        $this->population = $population;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getPopulation()
    {
        return $this->population;
    }
}
