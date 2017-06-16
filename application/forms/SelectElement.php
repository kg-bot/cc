<?php
namespace App\forms;

use App\extensions\rates\drivers\Redis;

class SelectElement extends \Zend_Form_Element_Select
{
    public function init()
    {
        $this->setAttrib('class', 'form-control');
        /** @var RatesCollectionInterface */
        $rates = (new Redis())->all();

        /** @var array Array of RateInterface instances */
        foreach ($rates->getRates() as $rate => $rateObject) {
            $this->addMultiOption($rate, $rate);
        }

        $this->setValue($rates->getBase());
    }
}