<?php

namespace Custom\LoginAsCustomer\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Connector
{
    /*custom setting */
    const CONFIG_LAC_ENABLED = 'custom/general/login_as_customer_enabled';
    const CONFIG_LAC_CUSTOMER_GRID_PAGE = 'custom/button_visibility/customer_grid_page';
    const CONFIG_LAC_CUSTOMER_VIEW_PAGE = 'custom/button_visibility/customer_edit_page';
    const CONFIG_LAC_ORDER_VIEW_PAGE = 'custom/button_visibility/order_view_page';
    const CONFIG_LAC_ORDER_GRID_PAGE = 'custom/button_visibility/order_grid_page';

    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /*custom check configuration setting code*/

    public function getCustomerLoginEnable()
    {
        return $this->scopeConfig->getValue(self::CONFIG_LAC_ENABLED);
    }

    public function getCustomerViewPage()
    {
        return $this->scopeConfig->getValue(self::CONFIG_LAC_CUSTOMER_VIEW_PAGE);
    }

    public function getCustomerGridPage()
    {
        return $this->scopeConfig->getValue(self::CONFIG_LAC_CUSTOMER_GRID_PAGE);
    }

    public function getOrderViewPage()
    {
        return $this->scopeConfig->getValue(self::CONFIG_LAC_ORDER_VIEW_PAGE);
    }

    public function getOrderGridPage()
    {
        return $this->scopeConfig->getValue(self::CONFIG_LAC_ORDER_GRID_PAGE);
    }
}
