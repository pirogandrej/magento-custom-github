<?php

namespace Custom\CmsMenu\Block\Fronthtml;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Custom\CmsMenu\Model\ResourceModel\Link as LinkResource;
use Custom\CmsMenu\Model\RelFactory;

class Link extends Template
{
    protected $_relFactory;

    public function __construct
    (
        Context $context,
        RelFactory $relFactory,

        array $data = []
    )
    {
        $this->_relFactory = $relFactory;

        parent::__construct($context, $data);
    }

    public function getJoinData($curPage)
    {
        $relCollection = $this->_relFactory->create()->getCollection();
        $second_table_name = LinkResource::TBL_LINK;

        $relCollection
            ->addFieldToSelect('*')
            ->addFieldToFilter('main_table.page_id', $curPage)
            ->addFieldToFilter('second.status', 1)
            ->join(
                array('second' => $second_table_name),
                'main_table.link_id = second.link_id'
            );

        return $relCollection;
    }

    public function getLink()
    {
        $data = [];

        //get data with current cms_page id
        $blockPage = $this->getLayout()->getBlock('cms_page');
        if ($blockPage) {
            $curPage = $blockPage->getPage()->getId();
            $data = $this->getJoinData($curPage);
        }

        return $data;
    }

}




