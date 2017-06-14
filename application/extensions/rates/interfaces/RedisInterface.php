<?php
namespace App\Extensions\Rates\Interfaces;

interface RedisInterface
{
    /**
     * Fetchs all rates from Redis
     * 
     * @return RatesCollectionInterface
     */
    public function all();

    /**
     * Does a Redis lookup on desired currency
     * 
     * @param  String $currency
     * 
     * @return RateInterface
     */
    public function find($currency);

    /**
     * Save rates to the Redis
     * 
     * @param RatesCollectionInterface $rates Collection of rates
     */
    public function save(RatesCollectionInterface $rates);
}