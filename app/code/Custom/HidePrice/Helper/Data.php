<?php

namespace Custom\HidePrice\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Http\Context as HttpContext;

class Data extends AbstractHelper
{
    const XML_CONFIG_ENABLE = 'hideprice/configuration/enablehideprice';

    private $_httpContext;

    public function __construct
    (
        Context $context,
        HttpContext $httpContext
    )
    {
        $this->_httpContext = $httpContext;
        parent::__construct($context);
    }

    public function isLoggedIn()
    {
        $isLoggedIn = $this->_httpContext->getValue(CustomerContext::CONTEXT_AUTH);
        return $isLoggedIn;
    }

    public function isHidePrice()
    {
        $result = $this->scopeConfig->getValue(self::XML_CONFIG_ENABLE);
        return $result?true:false;
    }

    public function isHide()
    {
        $isHide = false;
        if (($this->isHidePrice()) && (!$this->isLoggedIn()))
        {
            $isHide = true;
        }
        return $isHide;
    }
}
