<?php

namespace Custom\LoginAsCustomer\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Custom\LoginAsCustomer\Model\Connector;

class Actions extends Column
{
    protected $urlBuilder;

    protected $connector;

    protected $authorization;

    protected $scopeConfig;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        AuthorizationInterface $authorization,
        ScopeConfigInterface $scopeConfig,
        Connector $connector,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->authorization = $authorization;
        $this->scopeConfig = $scopeConfig ;
        $this->connector = $connector;
    }

    public function prepareDataSource(array $dataSource)
    {
        /* This section for create login text using foreach loop*/
        if (isset($dataSource['data']['items'])) {
            $hidden = !$this->authorization->isAllowed('Custom_LoginAsCustomer::CustomerGrid');
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->prepareHtml($item['entity_id']);
            }
        }
        return $dataSource;
    }

    public function prepareHtml($id)
    {
        $url=$this->urlBuilder->getUrl(
            'loginascustomer/loginascustomer/login',
            ['customer_id' => $id, 'login_from' => 1]
        );
        $finalHtml = '<a href="'.$url.'" target="_blank">Login</a>';
        return $finalHtml;
    }

    protected function _getData($key)
    {
        /* This method used to hide the column
           if config setting is off for login as customer
        */
            $loginAsCustomerEnabled = $this->connector->getCustomerLoginEnable();

        /*Check config setting for grid listing on or off*/

            $isGridViewEnabled = $this->connector->getCustomerGridPage();

        /*  Check the condition config setting for login
            as customer is on or off if it's 0 then it's off hide the column
        */

            $hidden = $this->authorization->isAllowed('Custom_LoginAsCustomer::CustomerGrid');
        if ($loginAsCustomerEnabled != "1" || $isGridViewEnabled != "1" || $hidden != "1") {
            if ($key == 'config') {
                $data = parent::_getData($key);
                $data['componentDisabled'] = true;
                return $data;
            }
        }
        return parent::_getData($key);
    }
}
