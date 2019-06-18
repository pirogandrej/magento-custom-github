<?php

namespace Custom\Ajaxcart\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Checkout\Model\Session;

class Addproduct implements ObserverInterface {

    protected $_checkoutSession;

    public function __construct(Session $session){
        $this->_checkoutSession = $session;
    }

    public function execute(Observer $observer){
        $this->_checkoutSession->setShowCart(true);
    }
}