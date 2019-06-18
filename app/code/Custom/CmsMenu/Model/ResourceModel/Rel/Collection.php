<?php

namespace Custom\CmsMenu\Model\ResourceModel\Rel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Custom\CmsMenu\Model\Rel',
            'Custom\CmsMenu\Model\ResourceModel\Rel'
        );
    }
}