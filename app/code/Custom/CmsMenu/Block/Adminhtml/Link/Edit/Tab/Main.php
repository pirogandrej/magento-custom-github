<?php
namespace Custom\CmsMenu\Block\Adminhtml\Link\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Custom\CmsMenu\Model\System\Config\Status;

class Main extends Generic implements TabInterface
{
    protected $store;

    protected $_linkStatus;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Status $linkStatus,
        array $data = []
    ) {
        $this->_linkStatus = $linkStatus;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('cms_link');

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Link Information')]);

        if ($model->getId()) {
            $fieldset->addField('link_id', 'hidden', ['name' => 'link_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'path',
            'text',
            [
                'name' => 'path',
                'label' => __('Path'),
                'title' => __('Path'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'position',
            'text',
            [
                'name'      => 'position',
                'label'     => __('Position'),
                'title'     => __('Position'),
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name'      => 'status',
                'label'     => __('Status'),
                'options'   => $this->_linkStatus->toOptionArray()
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Main');
    }

    public function getTabTitle()
    {
        return __('Main');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
