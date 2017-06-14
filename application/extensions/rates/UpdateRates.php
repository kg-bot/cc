<?php
namespace App\Extensions\Rates;

require __DIR__ . '/../../../vendor/autoload.php';

use App\Extensions\Rates\Interfaces\UpdateRatesInterface;
use App\Extensions\Rates\Values\Rate;
use App\Extensions\Rates\Values\RatesCollection;
use App\Extensions\Rates\Drivers\Redis;

class UpdateRates implements UpdateRatesInterface
{
    protected $config;

    protected $siteUrl = null;
    protected $apiKey = null;

    protected $apiResponse = null;

    protected $ratesArray = null;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . '/../../configs/rates_api.ini', true);

        $this->siteUrl = $this->config['default']['api']['host'];
        $this->apiKey = $this->config['default']['api']['key'];

        $this->fetchRates();
        $this->createNewRates();
        $this->insertRatesIntoCache();
    }

    public function fetchRates()
    {
        # URL ready to request
        $url = $this->siteUrl . 'live?access_key=' . $this->apiKey;

        # Send CURL request
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        # Get CURL response
        $data = curl_exec($request);
        curl_close($request);

        if (!empty($data)) {
            # return JSON decoded data
            $this->apiResponse = json_decode($data, true);
        }

    }

    public function createNewRates()
    {
        if ($this->apiResponse !== null) {
            $ratesArray = [];

            foreach ($this->apiResponse['quotes'] as $currency => $rate) {
                $currency = substr($currency, 3, 3);

                $newRate = new Rate($rate);
                $ratesArray[$currency] = $newRate;
            }

            $this->ratesArray = $ratesArray;
        }
    }

    public function insertRatesIntoCache()
    {
        if ($this->ratesArray !== null) {

            $ratesCollection = new RatesCollection($this->apiResponse['quotes']['USD' . $this->apiResponse['source']], $this->ratesArray);

            $redis = new Redis();
            $redis->save($ratesCollection);
        }
    }
}