<?php

namespace Custom\CmsMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Backend\Helper\Js;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Model\AbstractModel;
use Custom\CmsMenu\Model\RelFactory;

class Link extends AbstractDb
{
    const TBL_LINK_PAGE = 'custom_cms_link_page';
    const TBL_LINK = 'custom_cms_link';
    const TBL_PAGE = 'cms_page';

    protected $_idFieldName = 'link_id';
    protected $_date;
    protected $_jsHelper;
    protected $_resource;
    protected $_relFactory;

    public function __construct
    (
        Context $context,
        DateTime $date,
        Js $jsHelper,
        ResourceConnection $Resource,
        RelFactory $relFactory,
        $resourcePrefix = null
    )
    {
        $this->_date = $date;
        $this->_jsHelper = $jsHelper;
        $this->_resource = $Resource;
        $this->_relFactory = $relFactory;
        parent::__construct($context, $resourcePrefix);
    }

    protected function _construct()
    {
        $this->_init(self::TBL_LINK, 'link_id');
    }

    protected function _beforeSave(AbstractModel $object)
    {
        $object->setUpdatedAt($this->_date->date());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->_date->date());
        }

        return parent::_beforeSave($object);
    }

    protected function _afterSave(AbstractModel $model)
    {
        $post = $model->getData();

        if (isset($post['page'])) {
            $pageIds = $this->_jsHelper->decodeGridSerializedInput($post['page']);

            $connection = $this->_resource->getConnection();
            $table = $this->_resource->getTableName(self::TBL_LINK_PAGE);

            $oldPage = (array) $model->getPage($model);
            $newPage = (array) $pageIds;

            $insert = array_diff($newPage, $oldPage);
            $delete = array_diff($oldPage, $newPage);

            if ($delete) {
                $where = ['link_id = ?' => (int)$model->getId(), 'page_id IN (?)' => $delete];
                $connection->delete($table, $where);
            }

            if ($insert) {
                $data = [];
                foreach ($insert as $page_id) {
                    $data[] = ['link_id' => (int)$model->getId(), 'page_id' => (int)$page_id];
                }
                $connection->insertMultiple($table, $data);
            }
        }
        return parent::_afterSave($model);
    }
}
