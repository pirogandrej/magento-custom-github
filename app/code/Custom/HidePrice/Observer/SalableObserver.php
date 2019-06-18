<?php

namespace Custom\HidePrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Custom\HidePrice\Helper\Data as ProductHelper;

class SalableObserver implements ObserverInterface
{
    protected $_helper;

    public function __construct(ProductHelper $helper) {
        $this->_helper = $helper;
    }

    public function execute(Observer $observer) {
        if ($this->_helper->isHide()) {
            $salable = $observer->getEvent()->getSalable();
            $salable->setIsSalable(false);
        }
    }
}