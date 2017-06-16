<?php

use App\forms\SelectElement;

class Application_Form_Convert extends \Zend_Form
{

    public function init()
    {
        $this
            ->setMethod('post')
            ->setAction('convert/')
            ->setAttrib('id', 'convert_form')
            ->addElement('text', 'amount', [
                'id'            =>  'convert_value',
                'class'         =>  'form-control',
                'required'      =>  true,
                'validators'    =>  array('Digits')
            ])
            ->addElement(new SelectElement('currency_in'))
            ->addElement(new SelectElement('currency_out'))
            ->addElement('hash', 'csrf', [
                'ignore'    =>  true
            ])
            ->addElement('submit', 'submit', [
                'ignore'    =>  true,
                'label'     =>  'Convert'
            ]);
    }


}

