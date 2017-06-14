<?php
namespace App\Extensions\Rates\Drivers;

use App\Extensions\Rates\Interfaces\RedisInterface;
use App\Extensions\Rates\Interfaces\RatesCollectionInterface;

class Redis implements RedisInterface
{
    /** @var \Predis\ClientInterface $redis */
    private $redis;

    public function __construct()
    {
        $this->redis = new \Predis\Client();
    }

    public function all()
    {
        return unserialize($this->redis->get("currency_rates"));
    }

    public function find($currency)
    {
        $rates = $this->all->getRates();

        return $rate[$currency];
    }

    public function save(RatesCollectionInterface $rates)
    {
        $this->redis->set("currency_rates", serialize($rates));
    }
}