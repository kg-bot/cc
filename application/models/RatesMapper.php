<?php

class Application_Model_RatesMapper
{

    protected $_db_table;

    public function __construct()
    {
        //Instantiate the Table Data Gateway for the User table
        $this->_db_table = new Application_Model_DbTable_Rates();
    }

    /**
     *
     * Method used to get all available currencies from database
     *
     * @return Void
     *
     */
    public function getAllCurrencies()
    {
        // We query db for all currencies
        $currencies = $this->_db_table->fetchAll();

        if (count($currencies) > 0) {
            return $currencies;
        } else {
            return false;
        }
    }

    /**
     *
     * Method used to get a rate of desired currency
     *
     * @param String $currency Three letter currency code
     *
     * @return String [] Error message if currency does not exist
     * @return Object $rates_object Rates object with current rate
     *
     */
    public function getRate($currency)
    {
        // First we need to check if rates are updated in the last hour
        $row     = $this->_db_table->fetchRow();
        $updated = strtotime($row->updated);
        if (time() - $updated > 3600) {
            $this->updateRates();
        }
        // We need to find rate for desired currency
        $select = $this->_db_table->select()->where("currency = ?", $currency);
        $result = $this->_db_table->fetchRow($select);

        // If rate is not found return error
        if (count($result) == 0) {
            return "There is no such currency.";
        }
        // If found, get the result, and map it to Rates object
        else {
            $rates_object = new Application_Model_Rates($result);

            // Return Rates object
            return $rates_object;
        }
    }

    /**
     *
     * Method used to update currency rates
     *
     * @return Void
     *
     */
    public function updateRates()
    {
        // First we clear (truncate) existing data
        $this->_db_table->getAdapter()->query('TRUNCATE TABLE ' . $this->_db_table->info(Zend_Db_Table::NAME));

        // Rows to add
        $rows = [];

        // We must iterate over quotes and add them to database
        foreach ($exchangeRates['quotes'] as $currency => $rate) {
            $currency = explode('USD', $currency, 2);
            $currency = $currency[1];

            // This reperesents table row
            $row = "('{$currency}', {$rate})";

            // We add each row to values
            array_push($rows, $row);
        }
        // Rows ready to insert
        $rows = implode(',', $rows);

        // We need table name
        $table_name = $this->_db_table->info()['name'];
        // We have to make custom SQL
        $sql = "INSERT INTO {$table_name} (`currency`, `rate`) VALUES {$rows}";
        $this->_db_table->getAdapter()->exec($sql);

    }
}
