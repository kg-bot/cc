<?php

class Application_Model_Rates
{
    public $currency;
    public $rate;

    public function __construct($user_row = null)
    {
        if (!is_null($user_row) && $user_row instanceof Zend_Db_Table_Row) {
            $this->currency = $user_row->currency;
            $this->rate     = $user_row->rate;
        }
    }
}
