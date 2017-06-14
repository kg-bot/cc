<?php
namespace App\Extensions\Rates\Interfaces;

interface RatesCollectionInterface
{
    /**
     * Returns array of all available rates and their values
     * 
     * @return array
     */
    public function getRates();

    /**
     * Returns base currency value
     * 
     * @return int
     */
    public function getBase();
}