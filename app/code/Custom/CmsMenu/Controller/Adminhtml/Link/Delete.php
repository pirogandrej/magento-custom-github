<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Link;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Custom\CmsMenu\Model\LinkFactory;

class Delete extends Action
{
    protected $_linkFactory;

    public function __construct(
        Context $context,
        LinkFactory $linkFactory
    )
    {
        $this->_linkFactory = $linkFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('link_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_linkFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The link has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['link_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a link to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}