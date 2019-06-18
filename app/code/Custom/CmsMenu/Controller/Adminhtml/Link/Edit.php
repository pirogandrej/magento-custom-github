<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Link;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Custom\CmsMenu\Model\LinkFactory;

class Edit extends Action
{
    protected $_coreRegistry = null;

    protected $resultPageFactory;

    protected $_linkFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        LinkFactory $linkFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_linkFactory = $linkFactory;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('link_id');
        $model = $this->_linkFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This link no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('cms_link', $model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Link') : __('New Link'),
            $id ? __('Edit Link') : __('New Link')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Links'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ?
                $model->getTitle() :
                __('New Link'));

        return $resultPage;
    }
}