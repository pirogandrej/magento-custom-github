<?php

namespace Custom\LoginAsCustomer\Controller\Login;

use Magento\Framework\App\Action\Action;
use Magento\Backend\App\Action\Context;
use Custom\LoginAsCustomer\Model\LoginAsCustomer;

class Index extends Action
{
    public $customLoginAsCustomer;

    public function __construct(
        Context $context,
        LoginAsCustomer $customLoginAsCustomer
    ) {
        $this->customLoginAsCustomer = $customLoginAsCustomer;
        parent::__construct($context);
    }

    public function execute()
    {
        $login = $this->checkLogin();
        if (!$login) {
            $this->_redirect('customer/account/login');
            return;
        }

        /* Log in */
        try {
            $login->authenticateCustomer();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->_redirect('customer/account/login');
            return;
        }

        $this->messageManager->addSuccessMessage(
            __('You are logged in as customer: %1', $login->getCustomer()->getName())
        );
        $this->_redirect('customer/account');
    }

    public function checkLogin()
    {
        $secret = $this->getRequest()->getParam('secret');
        if (!$secret) {
            $this->messageManager->addErrorMessage(__('Cannot login to account. No secret key provided.'));
            return false;
        }
        $login = $this->customLoginAsCustomer->loadNotUsed($secret);
        if ($login->getId()) {
                 return $login;
        } else {
            $this->messageManager->addErrorMessage(__('Cannot login to account. Secret key is not valid.'));
            return false;
        }
    }
}
