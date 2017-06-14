<?php
namespace App\Extensions\Rates\Interfaces;

interface RateInterface
{
    /**
     * Returns currency rate value
     * 
     * @return int|float
     */
    public function getRate();
}