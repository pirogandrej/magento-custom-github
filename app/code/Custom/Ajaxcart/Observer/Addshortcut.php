<?php

namespace Custom\Ajaxcart\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class Addshortcut implements ObserverInterface {

    public function execute(Observer $observer){
        if($container = $observer->getEvent()->getContainer()){
            if($container->getRequest()->isAjax()){
                $block = $container->getLayout()->createBlock('\Custom\Ajaxcart\Block\Shortcut')
                    ->setTemplate('Custom_Ajaxcart::shortcut.phtml');
                $container->addShortcut($block);
            }
        }
    }
}
