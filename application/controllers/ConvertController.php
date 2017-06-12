<?php

class ConvertController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     *
     * Method used to convert currency
     *
     * @param Integer $value How much currency you want to convert
     * @param String $in Three letter currency code you want to convert from
     * @param String $out Three letter currency code you want to convert to
     *
     * @return
     *
     */
    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $post_amount = $this->getRequest()->getPost("amount");
                if (is_numeric($post_amount)) {
                    $post_currencyIn  = $this->getRequest()->getPost("in");
                    $post_currencyOut = $this->getRequest()->getPost("out");

                    $mapper = new Application_Model_RatesMapper();

                    // We request row from rates table for $in currency
                    $in_rate = $mapper->getRate($post_currencyIn);
                    // We need to check if desired currency is presented in database
                    if ($in_rate instanceof Application_Model_Rates) {
                        $in_rate = $in_rate->rate;
                        // Now we need to get rate for desired currency
                        $out_rate = $mapper->getRate($post_currencyOut);
                        // We need to check if desired currency is presented in database
                        if ($out_rate instanceof Application_Model_Rates) {
                            $out_rate = $out_rate->rate;
                            // Now we need to actually convert
                            $base = $post_amount / $in_rate;

                            // This is our end result and we need to return this to user
                            $result = $base * $out_rate;

                            $responseArray = ['result' => round($result, 2)];
                        } else {
                            $responseArray = ['error' => "Your desired currency {$post_currencyOut} is not supported."];
                        }
                    } else {
                        $responseArray = ['error' => "Your base currency {$post_currencyIn} is not supported"];
                    }
                } else {
                    $responseArray = ['error' => "Amount must be number."];
                }
            } else {
                $responseArray = ['error' => "You must request this page over POST method."];
            }
        } else {
            $this->_redirect('/');
        }
        $this->_helper->json($responseArray);
    }

}
