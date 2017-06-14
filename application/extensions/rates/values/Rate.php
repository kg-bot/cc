<?php
namespace App\Extensions\Rates\Values;

use App\Extensions\Rates\Interfaces\RateInterface;

class Rate implements RateInterface
{
    /**
     * @var int|float
     */
    private $rate;

    public function __construct($rate)
    {
        $this->rate = $rate;
    }

    public function getRate()
    {
        return $this->rate;
    }
}