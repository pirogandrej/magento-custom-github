<?php

namespace Custom\CmsMenu\Block\Adminhtml\Link\Edit\Tab;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Custom\CmsMenu\Model\LinkFactory;

class Page extends Extended
{
    protected $pageCollectionFactory;

    protected $linkFactory;

    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $pageCollectionFactory,
        LinkFactory $linkFactory,
        array $data = []
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->linkFactory = $linkFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('pageGrid');
        $this->setDefaultSort('page_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('link_id')) {
            $this->setDefaultFilter(array('in_page' => 1));
        }
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_page') {
            $pageIds = $this->_getSelectedPage();

            if (empty($pageIds)) {
                $pageIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection();
            } else {
                if ($pageIds) {
                    $this->getCollection()->addFieldToFilter('page_id', array('nin' => $pageIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = $this->pageCollectionFactory->create();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_page',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_page',
                'align' => 'center',
                'index' => 'page_id',
                'values' => $this->_getSelectedPage(),
                'checked' => true,
            ]
        );

        $this->addColumn(
            'page_id',
            [
                'header' => __('Page ID'),
                'type' => 'number',
                'index' => 'page_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'identifier',
            [
                'header' => __('Identifier'),
                'index' => 'identifier',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'type' => 'number',
                'index' => 'is_active',
                'width' => '50px',
            ]
        );

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/pagegrid', ['_current' => true]);
    }

    public function getRowUrl($row)
    {
        return '';
    }

    protected function _getSelectedPage()
    {
        $link = $this->getLink();
        return $link->getPage($link);
    }

    public function getSelectedPage()
    {
        $link = $this->getLink();
        $selected = $link->getPage($link);

        if (!is_array($selected)) {
            $selected = [];
        } else {
            foreach ($selected as $key => $value) {
                $selected[$key] = $value;
            }
        }
        return $selected;
    }

    protected function getLink()
    {
        $linkId = $this->getRequest()->getParam('link_id');
        $link = $this->linkFactory->create();
        if ($linkId) {
            $link->load($linkId);
        }
        return $link;
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return true;
    }
}
