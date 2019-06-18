<?php

namespace Custom\HidePrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Custom\HidePrice\Helper\Data as ProductHelper;

class CollectionObserver implements ObserverInterface
{
    protected $_helper;

    public function __construct(ProductHelper $helper) {
        $this->_helper = $helper;
    }

    public function execute(Observer $observer) {
        if ($this->_helper->isHide()) {
            $collection = $observer->getEvent()->getCollection();
            foreach($collection as $product) {
                $product->setCanShowPrice(false);
            }
        }
    }
}