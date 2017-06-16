<?php

use App\forms\Convert;
use App\extensions\rates\drivers\Redis;
use App\extensions\converter\Converter;

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
            $form = new \Zend_Form();
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getPost())) {
                    $post = $this->getRequest()->getPost();

                    $redis = new Redis();

                    $from = $redis->find($post['in']);
                    $to = $redis->find($post['out']);
                    $amount = floatval($post['amount']);

                    $converter = (new Converter())->convert($from, $to, $amount);

                    $responseArray = ['result' => round($converter, 2)];
                } else {
                    $responseArray = ['error' => "Only numbers are allowed for amount."];
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
