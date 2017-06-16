<?php
namespace App\extensions\rates\drivers;

require __DIR__ . '/../../../../vendor/autoload.php';

use App\extensions\rates\interfaces\RedisInterface;
use App\extensions\rates\interfaces\RatesCollectionInterface;

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
        $rates = $this->all()->getRates();

        return $rates[$currency];
    }

    public function save(RatesCollectionInterface $rates)
    {
        $this->redis->set("currency_rates", serialize($rates));
    }
}