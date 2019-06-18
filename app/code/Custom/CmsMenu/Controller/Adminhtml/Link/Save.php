<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Link;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\SessionFactory;
use Custom\CmsMenu\Model\LinkFactory;

class Save extends Action
{
    protected $_sessionFactory;

    protected $_linkFactory;

    public function __construct
    (
        Context $context,
        SessionFactory $sessionFactory,
        LinkFactory $linkFactory
    )
    {
        $this->_sessionFactory = $sessionFactory;
        $this->_linkFactory = $linkFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_linkFactory->create();

            $id = $this->getRequest()->getParam('link_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();

                $this->messageManager->addSuccess(__('Your link has been successfully saved to the database.'));
                $this->_sessionFactory->create()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['link_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the link.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['link_id' => $this->getRequest()->getParam('link_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
