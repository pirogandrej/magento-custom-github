<?php

namespace Custom\LoginAsCustomer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class LoginAsCustomer extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('custom_login_as_customer', 'entity_id');
    }
}
