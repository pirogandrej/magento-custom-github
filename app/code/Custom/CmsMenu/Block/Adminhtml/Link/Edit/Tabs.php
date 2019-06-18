<?php

namespace Custom\CmsMenu\Block\Adminhtml\Link\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('link_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Link Information'));
    }

    protected function _prepareLayout()
    {
        $this->addTab(
            'main_tab',
            [
                'label' => __('Main'),
                'title' => __('Main'),
                'content' => $this->getLayout()->createBlock(
                    'Custom\CmsMenu\Block\Adminhtml\Link\Edit\Tab\Main'
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'page_tab',
            [
                'label' => __('Page'),
                'url' => $this->getUrl('cmsadmin/*/page', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        return parent::_prepareLayout();
    }

}

