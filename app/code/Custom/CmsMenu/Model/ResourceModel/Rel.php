<?php

namespace Custom\CmsMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Rel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(Link::TBL_LINK_PAGE, 'rel_id');
    }
}