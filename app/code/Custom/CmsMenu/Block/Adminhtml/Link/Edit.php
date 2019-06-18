<?php

namespace Custom\CmsMenu\Block\Adminhtml\Link;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;

class Edit extends Container
{
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'link_id';
        $this->_controller = 'adminhtml_link';
        $this->_blockGroup = 'Custom_CmsMenu';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete'));
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('cmsadmin/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
