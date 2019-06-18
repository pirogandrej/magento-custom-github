<?php

namespace Custom\LoginAsCustomer\Controller\Adminhtml\LoginAsCustomer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
             $resultPage->setActiveMenu('Magento_Customer::customer');
             $resultPage->getConfig()->getTitle()->prepend(__("Login As Customer"));
             return $resultPage;
    }
}
