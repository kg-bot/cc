<?php
namespace App\extensions\converter;

use App\extensions\converter\interfaces\ConverterInterface;
use App\extensions\rates\interfaces\RateInterface;

class Converter implements ConverterInterface
{
    public function convert(RateInterface $from, RateInterface $to, float $amount)
    {
        return ($to->getRate() / $from->getRate()) * $amount;
    }
}