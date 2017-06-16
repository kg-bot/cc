<?php
namespace App\extensions\rates\values;

use App\extensions\rates\interfaces\RateInterface;

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