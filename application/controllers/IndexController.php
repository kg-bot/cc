<?php

use App\extensions\rates\drivers\Redis;
use App\Extensions\Rates\Interfaces\RatesCollectionInterface;
use App\forms\Convert;

class IndexController extends Zend_Controller_Action
{

    protected $form;

    public function init()
    {
        $this->form = new Application_Form_Convert();
    }

    public function indexAction()
    {

        $redis = new Redis();
        // Get all currencies, returns RatesCollection
        $currencies = $redis->all();

        if ($currencies instanceof RatesCollectionInterface) {
            $this->view->allCurrencies = $currencies->getRates();
            $this->view->form = $this->form;
        }
    }

}
