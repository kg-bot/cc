<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $mapper = new Application_Model_RatesMapper();

        // Get all currencies
        $currencies = $mapper->getAllCurrencies();

        if($currencies) {
        	$this->view->all_currencies = $currencies;
        }
        else {
        	$this->view->all_currencies = "ERROR";
        }
    }


}

