<?php
namespace App\extensions\converter\interfaces;

use App\extensions\rates\interfaces\RateInterface;

interface ConverterInterface
{
    /**
     * Convert currency
     * 
     * @param  RateInterface $from
     * @param  RateInterface $to
     * @param  float        $amount
     * 
     * @return int
     */
    public function convert(RateInterface $from, RateInterface $to, float $amount);
}