<?php
namespace App\extensions\rates\interfaces;

interface RateInterface
{
    /**
     * Returns currency rate value
     * 
     * @return int|float
     */
    public function getRate();
}