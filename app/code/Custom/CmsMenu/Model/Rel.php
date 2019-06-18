<?php

namespace Custom\CmsMenu\Model;

use Magento\Framework\Model\AbstractModel;

class Rel extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Custom\CmsMenu\Model\ResourceModel\Rel');
    }
}