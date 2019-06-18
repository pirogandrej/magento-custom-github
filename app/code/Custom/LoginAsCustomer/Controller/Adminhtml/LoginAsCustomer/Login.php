<?php

namespace Custom\LoginAsCustomer\Controller\Adminhtml\LoginAsCustomer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Backend\Model\Auth\Session;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Url;
use Custom\LoginAsCustomer\Model\LoginAsCustomer;

class Login extends Action
{
    public $resultPageFactory;

    public $customLoginCustomer;

    public $customRemoteAddress;

    public $customSession;

    public $customStoreManager;

    public $customUrl;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        RemoteAddress $customRemoteAddress,
        Session $customSession,
        StoreManagerInterface $customStoreManager,
        Url $customUrl,
        LoginAsCustomer $customLoginCustomer
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customRemoteAddress = $customRemoteAddress;
        $this->customSession = $customSession;
        $this->customStoreManager = $customStoreManager;
        $this->customUrl = $customUrl;
        $this->customLoginCustomer = $customLoginCustomer;
        parent::__construct($context);
    }

    public function execute()
    {
        $customerId = (int) $this->getRequest()->getParam('customer_id');
        $loginFrom = (int) $this->getRequest()->getParam('login_from');
        $login = $this->customLoginCustomer->setCustomerId($customerId);

        $login->deleteNotUsed();
        $customer = $login->getCustomer();

        if (!$customer->getId()) {
            $this->messageManager->addErrorMessage(__('This is not valid customer/ Customer not found'));
            $this->_redirect('customer/index/index');
            return;
        }
        $user = $this->customSession->getUser();

        /*Pass admin data*/
        $adminId = $user->getId();
        $adminName = $user->getfirstname();
        $adminUsername = $user->getusername();
        $customerEmail = $customer->getEmail();
        $customerStoreId = $customer->getData('store_id');

        /*Get ip address of client*/
        $ip = $this->customRemoteAddress->getRemoteAddress();

        /*Client ip address code end*/
        $login->generate(
            $adminId,
            $adminName,
            $adminUsername,
            $loginFrom,
            $customerEmail,
            $ip
        );

        $store = $this->customStoreManager->getStore($customerStoreId);
        $url = $this->customUrl->setScope($store);
        $redirectUrl = $url->getUrl(
            'loginascustomer/login/index',
            ['secret' => $login->getSecret(),
                '_nosid' => true]
        );
        $this->getResponse()->setRedirect(
            $redirectUrl
        );
    }
}
