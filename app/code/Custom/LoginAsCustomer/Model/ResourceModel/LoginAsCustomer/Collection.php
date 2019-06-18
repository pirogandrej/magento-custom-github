<?php

namespace Custom\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(
            'Custom\LoginAsCustomer\Model\LoginAsCustomer',
            'Custom\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer'
        );
    }
}
