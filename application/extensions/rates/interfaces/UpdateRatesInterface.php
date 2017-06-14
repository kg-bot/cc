<?php
namespace App\Extensions\Rates\Interfaces;

/**
 * Interface defining how we should implement API calls
 * and fatching rates info
 */

interface UpdateRatesInterface
{
    /**
     * Method used to fetch rates from API
     * 
     * @return JSON JSON decoded value
     * @return  null If API response is empty returns null
     */
    public function fetchRates();

    /**
     * Method used to create a new rate from api response
     * 
     * @return void
     */
    public function createNewRates();

    /**
     * Method used to create RatesCollection and insert it into Redis cache
     * 
     * @return void
     */
    public function insertRatesIntoCache();
}