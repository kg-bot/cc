<?php

use Phinx\Seed\AbstractSeed;

class RatesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        // set API Endpoint and access key (and any options of your choice)
        $endpoint   = 'live';
        $access_key = '012900ca6a975aa588e6e7a833c51f60';

        // Initialize CURL:
        $ch = curl_init('http://apilayer.net/api/' . $endpoint . '?access_key=' . $access_key . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        // Array of table rows that we need to populate
        $data = [];

        // We must iterate over quotes and add them to database
        foreach ($exchangeRates['quotes'] as $currency => $rate) {
            $currency = explode('USD', $currency, 2);
            $currency = $currency[1];

            // This reperesents table row
            $info = [
                'currency' => $currency,
                'rate'     => $rate,
            ];

            // We push every row to $data
            array_push($data, $info);

        }

        // Save new rates to database
        $rates = $this->table('rates');
        $rates->insert($data)
            ->save();
    }
}
