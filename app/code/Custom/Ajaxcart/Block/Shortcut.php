<?php

namespace Custom\Ajaxcart\Block;

use Magento\Checkout\Block\Cart\AbstractCart;
use Magento\Catalog\Block\ShortcutInterface;

class Shortcut extends AbstractCart implements ShortcutInterface {

    public function getAlias(){
        return 'cart_delay';
    }

    public function getCacheKeyInfo()
    {
        $result = parent::getCacheKeyInfo();
        $result[] = $this->_checkoutSession->getShowCart();
        return $result;
    }

    protected function _toHtml(){
        if($this->_checkoutSession->getShowCart()&&$this->getRequest()->getActionName()=='load'){
            $this->_checkoutSession->setShowCart(false);
            return parent::_toHtml();
        }
        return '';
    }

    public function getDelay(){
        return 1000*$this->_scopeConfig->getValue('custom_ajaxcart/general/cart_add_delay');
    }
}