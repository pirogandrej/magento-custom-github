<?php

namespace Custom\CmsMenu\Model\ResourceModel\Link;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'link_id';
    protected $_eventPrefix = 'link_link_collection';
    protected $_eventObject = 'link_collection';

    protected function _construct()
    {
        $this->_init(
            'Custom\CmsMenu\Model\Link',
            'Custom\CmsMenu\Model\ResourceModel\Link'
        );
    }
}

