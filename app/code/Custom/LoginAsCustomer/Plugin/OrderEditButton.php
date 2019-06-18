<?php

namespace Custom\LoginAsCustomer\Plugin;

use Magento\Backend\Block\Widget\Button\Toolbar;
use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\UrlInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Sales\Block\Adminhtml\Order\View;
use Custom\LoginAsCustomer\Model\Connector;

class OrderEditButton
{
    protected $urlBuilder;

    protected $authorization;

    protected $customer;

    protected $connector;

    public function __construct(
        Connector $connector,
        AuthorizationInterface $authorization,
        UrlInterface $urlBuilder,
        CustomerRepository $customer
    ) {
        $this->connector = $connector;
        $this->urlBuilder = $urlBuilder;
        $this->authorization = $authorization;
        $this->customer = $customer;
    }

    public function beforePushButtons(
        Toolbar $toolbar,
        AbstractBlock $context,
        ButtonList $buttonList
    ) {
        if (!$context instanceof View) {
            return [$context, $buttonList];
        }

        //Check customer id and configuration setting to show Button or not
        $customerId = $context->getOrder()->getCustomerId();
        $loginAsCustomerEnabled = $this->connector->getCustomerLoginEnable();
        $orderViewPage = $this->connector->getOrderViewPage();

        //Check customer is exist in customer table or not if not then return on detail page
        try {
            $this->customer->getById($customerId)->getId();
        } catch (\Exception $e) {
            return [$context, $buttonList];
        }

        //Check ACL setting option
        $hidden = $this->authorization->isAllowed('Custom_LoginAsCustomer::OrderView');

        if (isset($customerId) && $loginAsCustomerEnabled == "1" && $orderViewPage == "1" && $hidden == "1") {
            $urlData = $this->urlBuilder->getUrl(
                'loginascustomer/loginascustomer/login',
                ['customer_id' => $customerId,
                    'login_from' => 3
                ]
            );
            $buttonList->add(
                'loginascustomer',
                [
                    'label' => __('Login As Customer'),
                    'class' => 'loginascustomer',
                    'onclick' => 'window.open(\'' . $urlData . '\', \'_blank\')'
                ]
            );
        }

        return [$context, $buttonList, $toolbar];
    }
}
