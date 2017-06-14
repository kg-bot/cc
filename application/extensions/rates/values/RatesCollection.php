<?php
namespace App\Extensions\Rates\Values;

use App\Extensions\Rates\Interfaces\RatesCollectionInterface;

class RatesCollection implements RatesCollectionInterface
{
    /**
     * @var string
     */
    private $base;

    /** 
     * @var array
     */
    private $rates;

    public function __construct($base, array $rates)
    {
        $this->base = $base;
        $this->rates = $rates;
    }

    public function getRates()
    {
        return $this->rates;
    }

    public function getBase()
    {
        return $this->base;
    }
}