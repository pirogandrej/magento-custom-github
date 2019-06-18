<?php

namespace Custom\CmsMenu\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Custom\CmsMenu\Model\ResourceModel\Link as LinkResource;

class Link extends AbstractModel implements IdentityInterface
{

//    const STATUS_ENABLED = 1;
//    const STATUS_DISABLED = 0;
//
    const CACHE_TAG = LinkResource::TBL_LINK;
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init('Custom\CmsMenu\Model\ResourceModel\Link');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getPage(Link $object)
    {
        $tbl = $this->getResource()->getTable(LinkResource::TBL_LINK_PAGE);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['page_id']
        )
            ->where(
                'link_id = ?',
                (int)$object->getId()
            );
        $result = $this->getResource()->getConnection()->fetchCol($select);
        return $result;
    }
}
